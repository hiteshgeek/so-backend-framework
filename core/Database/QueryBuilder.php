<?php

namespace Core\Database;

/**
 * Query Builder
 */
class QueryBuilder
{
    protected Connection $connection;
    protected string $table = '';
    protected array $wheres = [];
    protected array $bindings = [];
    protected array $columns = ['*'];
    protected ?int $limitValue = null;
    protected ?int $offsetValue = null;
    protected array $orders = [];
    protected array $joins = [];
    protected array $groups = [];
    protected array $havings = [];
    protected array $havingBindings = [];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function select(...$columns): self
    {
        $this->columns = array_map(fn($col) => $this->sanitizeColumn($col), $columns);
        return $this;
    }

    public function where(string $column, string $operator, $value): self
    {
        $column = $this->sanitizeColumn($column);
        $this->validateOperator($operator);
        $this->wheres[] = ['type' => 'basic', 'column' => $column, 'operator' => $operator, 'value' => $value, 'boolean' => 'and'];
        $this->bindings[] = $value;
        return $this;
    }

    public function orWhere(string $column, string $operator, $value): self
    {
        $column = $this->sanitizeColumn($column);
        $this->validateOperator($operator);
        $this->wheres[] = ['type' => 'basic', 'column' => $column, 'operator' => $operator, 'value' => $value, 'boolean' => 'or'];
        $this->bindings[] = $value;
        return $this;
    }

    public function whereIn(string $column, array $values, string $boolean = 'and'): self
    {
        $column = $this->sanitizeColumn($column);
        if (empty($values)) {
            // No values means no matches - add impossible condition
            $this->wheres[] = ['type' => 'raw', 'sql' => '1 = 0', 'boolean' => $boolean];
            return $this;
        }
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $this->wheres[] = ['type' => 'in', 'column' => $column, 'placeholders' => $placeholders, 'boolean' => $boolean];
        $this->bindings = array_merge($this->bindings, $values);
        return $this;
    }

    public function whereNotIn(string $column, array $values, string $boolean = 'and'): self
    {
        $column = $this->sanitizeColumn($column);
        if (empty($values)) {
            return $this; // No exclusions needed
        }
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $this->wheres[] = ['type' => 'not_in', 'column' => $column, 'placeholders' => $placeholders, 'boolean' => $boolean];
        $this->bindings = array_merge($this->bindings, $values);
        return $this;
    }

    public function whereNull(string $column, string $boolean = 'and'): self
    {
        $column = $this->sanitizeColumn($column);
        $this->wheres[] = ['type' => 'null', 'column' => $column, 'boolean' => $boolean];
        return $this;
    }

    public function whereNotNull(string $column, string $boolean = 'and'): self
    {
        $column = $this->sanitizeColumn($column);
        $this->wheres[] = ['type' => 'not_null', 'column' => $column, 'boolean' => $boolean];
        return $this;
    }

    public function whereBetween(string $column, $min, $max, string $boolean = 'and'): self
    {
        $column = $this->sanitizeColumn($column);
        $this->wheres[] = ['type' => 'between', 'column' => $column, 'boolean' => $boolean];
        $this->bindings[] = $min;
        $this->bindings[] = $max;
        return $this;
    }

    public function whereRaw(string $sql, array $bindings = [], string $boolean = 'and'): self
    {
        $this->wheres[] = ['type' => 'raw', 'sql' => $sql, 'boolean' => $boolean];
        $this->bindings = array_merge($this->bindings, $bindings);
        return $this;
    }

    public function join(string $table, string $first, string $operator, string $second, string $type = 'inner'): self
    {
        $this->sanitizeColumn($table);
        $first = $this->sanitizeColumn($first);
        $this->validateOperator($operator);
        $second = $this->sanitizeColumn($second);
        $this->joins[] = [
            'type' => strtoupper($type),
            'table' => $table,
            'first' => $first,
            'operator' => $operator,
            'second' => $second
        ];
        return $this;
    }

    public function leftJoin(string $table, string $first, string $operator, string $second): self
    {
        return $this->join($table, $first, $operator, $second, 'left');
    }

    public function rightJoin(string $table, string $first, string $operator, string $second): self
    {
        return $this->join($table, $first, $operator, $second, 'right');
    }

    public function groupBy(...$columns): self
    {
        $sanitized = array_map(fn($col) => $this->sanitizeColumn($col), $columns);
        $this->groups = array_merge($this->groups, $sanitized);
        return $this;
    }

    public function having(string $column, string $operator, $value): self
    {
        $column = $this->sanitizeColumn($column);
        $this->validateOperator($operator);
        $this->havings[] = ['column' => $column, 'operator' => $operator, 'boolean' => 'and'];
        $this->havingBindings[] = $value;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $column = $this->sanitizeColumn($column);
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            throw new \InvalidArgumentException("Invalid order direction: {$direction}");
        }
        $this->orders[] = ['column' => $column, 'direction' => $direction];
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limitValue = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offsetValue = $offset;
        return $this;
    }

    public function get(): array
    {
        $sql = $this->buildSelectSql();
        return $this->connection->fetchAll($sql, $this->bindings);
    }

    public function first(): ?array
    {
        $sql = $this->buildSelectSql();
        return $this->connection->fetchOne($sql, $this->bindings);
    }

    public function find(int $id, string $column = 'id'): ?array
    {
        return $this->where($column, '=', $id)->first();
    }

    public function count(string $column = '*'): int
    {
        $column = $this->sanitizeColumn($column);
        $sql = "SELECT COUNT({$column}) as aggregate FROM {$this->table}";

        if (!empty($this->joins)) {
            $sql = "SELECT COUNT({$column}) as aggregate FROM {$this->table}" . $this->buildJoins();
        }

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
        }

        if (!empty($this->groups)) {
            $sql .= ' GROUP BY ' . implode(', ', $this->groups);
        }

        $result = $this->connection->fetchOne($sql, $this->bindings);
        return (int) ($result['aggregate'] ?? 0);
    }

    public function sum(string $column): float
    {
        $column = $this->sanitizeColumn($column);
        $sql = "SELECT SUM({$column}) as aggregate FROM {$this->table}";

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
        }

        $result = $this->connection->fetchOne($sql, $this->bindings);
        return (float) ($result['aggregate'] ?? 0);
    }

    public function avg(string $column): float
    {
        $column = $this->sanitizeColumn($column);
        $sql = "SELECT AVG({$column}) as aggregate FROM {$this->table}";

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
        }

        $result = $this->connection->fetchOne($sql, $this->bindings);
        return (float) ($result['aggregate'] ?? 0);
    }

    public function max(string $column)
    {
        $column = $this->sanitizeColumn($column);
        $sql = "SELECT MAX({$column}) as aggregate FROM {$this->table}";

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
        }

        $result = $this->connection->fetchOne($sql, $this->bindings);
        return $result['aggregate'] ?? null;
    }

    public function min(string $column)
    {
        $column = $this->sanitizeColumn($column);
        $sql = "SELECT MIN({$column}) as aggregate FROM {$this->table}";

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
        }

        $result = $this->connection->fetchOne($sql, $this->bindings);
        return $result['aggregate'] ?? null;
    }

    public function exists(): bool
    {
        return $this->count() > 0;
    }

    public function doesntExist(): bool
    {
        return !$this->exists();
    }

    public function paginate(int $perPage = 15, int $page = 1): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        // Clone bindings for count query
        $countBindings = $this->bindings;

        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}";
        if (!empty($this->wheres)) {
            $countSql .= ' WHERE ' . $this->buildWheres();
        }
        $countResult = $this->connection->fetchOne($countSql, $countBindings);
        $total = (int) ($countResult['total'] ?? 0);

        // Get paginated data
        $this->limit($perPage)->offset($offset);
        $data = $this->get();

        $lastPage = (int) ceil($total / $perPage);

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => $lastPage,
            'from' => $total > 0 ? $offset + 1 : 0,
            'to' => min($offset + $perPage, $total),
            'has_more' => $page < $lastPage,
        ];
    }

    public function simplePaginate(int $perPage = 15, int $page = 1): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        // Fetch one extra to check if there are more
        $this->limit($perPage + 1)->offset($offset);
        $data = $this->get();

        $hasMore = count($data) > $perPage;
        if ($hasMore) {
            array_pop($data); // Remove the extra record
        }

        return [
            'data' => $data,
            'per_page' => $perPage,
            'current_page' => $page,
            'has_more' => $hasMore,
        ];
    }

    public function insert(array $data): bool
    {
        $sanitizedKeys = array_map(fn($col) => $this->sanitizeColumn($col), array_keys($data));
        $columns = implode(', ', $sanitizedKeys);
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        return $this->connection->execute($sql, array_values($data));
    }

    public function update(array $data): bool
    {
        $sets = [];
        $bindings = [];

        foreach ($data as $column => $value) {
            $column = $this->sanitizeColumn($column);
            $sets[] = "{$column} = ?";
            $bindings[] = $value;
        }

        $sets = implode(', ', $sets);
        $sql = "UPDATE {$this->table} SET {$sets}";

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
            $bindings = array_merge($bindings, $this->bindings);
        }

        return $this->connection->execute($sql, $bindings);
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM {$this->table}";

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
        }

        return $this->connection->execute($sql, $this->bindings);
    }

    protected function buildSelectSql(): string
    {
        $columns = implode(', ', $this->columns);
        $sql = "SELECT {$columns} FROM {$this->table}";

        if (!empty($this->joins)) {
            $sql .= $this->buildJoins();
        }

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
        }

        if (!empty($this->groups)) {
            $sql .= ' GROUP BY ' . implode(', ', $this->groups);
        }

        if (!empty($this->havings)) {
            $sql .= ' HAVING ' . $this->buildHavings();
            $this->bindings = array_merge($this->bindings, $this->havingBindings);
        }

        if (!empty($this->orders)) {
            $sql .= ' ORDER BY ' . $this->buildOrders();
        }

        if ($this->limitValue !== null) {
            $sql .= " LIMIT {$this->limitValue}";
        }

        if ($this->offsetValue !== null) {
            $sql .= " OFFSET {$this->offsetValue}";
        }

        return $sql;
    }

    protected function buildJoins(): string
    {
        $sql = '';
        foreach ($this->joins as $join) {
            $sql .= " {$join['type']} JOIN {$join['table']} ON {$join['first']} {$join['operator']} {$join['second']}";
        }
        return $sql;
    }

    protected function buildWheres(): string
    {
        $sql = [];

        foreach ($this->wheres as $i => $where) {
            $boolean = $i === 0 ? '' : " {$where['boolean']} ";

            switch ($where['type']) {
                case 'basic':
                    $sql[] = "{$boolean}{$where['column']} {$where['operator']} ?";
                    break;
                case 'in':
                    $sql[] = "{$boolean}{$where['column']} IN ({$where['placeholders']})";
                    break;
                case 'not_in':
                    $sql[] = "{$boolean}{$where['column']} NOT IN ({$where['placeholders']})";
                    break;
                case 'null':
                    $sql[] = "{$boolean}{$where['column']} IS NULL";
                    break;
                case 'not_null':
                    $sql[] = "{$boolean}{$where['column']} IS NOT NULL";
                    break;
                case 'between':
                    $sql[] = "{$boolean}{$where['column']} BETWEEN ? AND ?";
                    break;
                case 'raw':
                    $sql[] = "{$boolean}{$where['sql']}";
                    break;
            }
        }

        return implode('', $sql);
    }

    protected function buildHavings(): string
    {
        $sql = [];
        foreach ($this->havings as $i => $having) {
            $boolean = $i === 0 ? '' : " {$having['boolean']} ";
            $sql[] = "{$boolean}{$having['column']} {$having['operator']} ?";
        }
        return implode('', $sql);
    }

    protected function buildOrders(): string
    {
        $sql = [];

        foreach ($this->orders as $order) {
            $sql[] = "{$order['column']} {$order['direction']}";
        }

        return implode(', ', $sql);
    }

    public function transaction(callable $callback)
    {
        $this->connection->beginTransaction();

        try {
            $result = $callback($this);
            $this->connection->commit();
            return $result;
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    /**
     * Validate and sanitize a column name to prevent SQL injection
     */
    protected function sanitizeColumn(string $column): string
    {
        // Allow * for count(*) and table.*
        if ($column === '*') {
            return $column;
        }

        // Allow table.* format (e.g. users.*)
        if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*\.\*$/', $column)) {
            return $column;
        }

        // Allow table.column format and simple column names
        // Only alphanumeric, underscores, and dots allowed
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*(\.[a-zA-Z_][a-zA-Z0-9_]*)?$/', $column)) {
            throw new \InvalidArgumentException("Invalid column name: {$column}");
        }

        return $column;
    }

    /**
     * Validate a comparison operator to prevent SQL injection
     */
    protected function validateOperator(string $operator): void
    {
        $valid = ['=', '<', '>', '<=', '>=', '<>', '!=', 'LIKE', 'like', 'NOT LIKE', 'not like', 'IN', 'in', 'NOT IN', 'not in'];
        if (!in_array($operator, $valid, true)) {
            throw new \InvalidArgumentException("Invalid operator: {$operator}");
        }
    }
}
