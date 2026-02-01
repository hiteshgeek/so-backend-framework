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
    protected bool $distinct = false;
    protected array $unions = [];
    protected array $unionBindings = [];

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

    /**
     * Add a raw expression to the SELECT clause
     *
     * Usage: selectRaw('COUNT(*) as total, SUM(amount) as sum')
     */
    public function selectRaw(string $expression, array $bindings = []): self
    {
        $this->columns[] = $expression;
        $this->bindings = array_merge($this->bindings, $bindings);
        return $this;
    }

    /**
     * Add a subquery as a SELECT column
     *
     * Usage: selectSub(fn($q) => $q->select('COUNT(*)')->from('orders')->whereRaw('orders.user_id = users.id'), 'order_count')
     */
    public function selectSub(\Closure $callback, string $as): self
    {
        $subQuery = new static($this->connection);
        $callback($subQuery);

        $this->columns[] = '(' . $subQuery->toSql() . ') AS ' . $this->sanitizeColumn($as);
        $this->bindings = array_merge($this->bindings, $subQuery->getBindings());

        return $this;
    }

    /**
     * Add columns to existing select
     */
    public function addSelect(...$columns): self
    {
        // If columns was just ['*'], replace it
        if ($this->columns === ['*']) {
            $this->columns = [];
        }

        foreach ($columns as $column) {
            $this->columns[] = $this->sanitizeColumn($column);
        }

        return $this;
    }

    public function distinct(): self
    {
        $this->distinct = true;
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

    /**
     * Add a WHERE IN subquery clause
     *
     * Usage: whereInSub('id', fn($q) => $q->select('user_id')->from('orders'))
     */
    public function whereInSub(string $column, \Closure $callback, string $boolean = 'and', bool $not = false): self
    {
        $column = $this->sanitizeColumn($column);

        $subQuery = new static($this->connection);
        $callback($subQuery);

        $operator = $not ? 'NOT IN' : 'IN';
        $sql = "{$column} {$operator} (" . $subQuery->toSql() . ")";

        $this->wheres[] = ['type' => 'raw', 'sql' => $sql, 'boolean' => $boolean];
        $this->bindings = array_merge($this->bindings, $subQuery->getBindings());

        return $this;
    }

    /**
     * Add a WHERE NOT IN subquery clause
     */
    public function whereNotInSub(string $column, \Closure $callback, string $boolean = 'and'): self
    {
        return $this->whereInSub($column, $callback, $boolean, true);
    }

    /**
     * Add a WHERE EXISTS clause
     *
     * Usage: whereExists(fn($q) => $q->select('1')->from('orders')->whereRaw('orders.user_id = users.id'))
     */
    public function whereExists(\Closure $callback, string $boolean = 'and', bool $not = false): self
    {
        $subQuery = new static($this->connection);
        $callback($subQuery);

        $operator = $not ? 'NOT EXISTS' : 'EXISTS';
        $sql = "{$operator} (" . $subQuery->toSql() . ")";

        $this->wheres[] = ['type' => 'raw', 'sql' => $sql, 'boolean' => $boolean];
        $this->bindings = array_merge($this->bindings, $subQuery->getBindings());

        return $this;
    }

    /**
     * Add a WHERE NOT EXISTS clause
     */
    public function whereNotExists(\Closure $callback, string $boolean = 'and'): self
    {
        return $this->whereExists($callback, $boolean, true);
    }

    /**
     * Add an OR WHERE EXISTS clause
     */
    public function orWhereExists(\Closure $callback): self
    {
        return $this->whereExists($callback, 'or');
    }

    /**
     * Add an OR WHERE NOT EXISTS clause
     */
    public function orWhereNotExists(\Closure $callback): self
    {
        return $this->whereExists($callback, 'or', true);
    }

    /**
     * Add a WHERE column subquery (column = (subquery))
     *
     * Usage: whereColumn('price', '=', fn($q) => $q->selectRaw('AVG(price)')->from('products'))
     */
    public function whereSub(string $column, string $operator, \Closure $callback, string $boolean = 'and'): self
    {
        $column = $this->sanitizeColumn($column);
        $this->validateOperator($operator);

        $subQuery = new static($this->connection);
        $callback($subQuery);

        $sql = "{$column} {$operator} (" . $subQuery->toSql() . ")";

        $this->wheres[] = ['type' => 'raw', 'sql' => $sql, 'boolean' => $boolean];
        $this->bindings = array_merge($this->bindings, $subQuery->getBindings());

        return $this;
    }

    /**
     * Add a LIKE where clause
     */
    public function whereLike(string $column, string $value, string $boolean = 'and'): self
    {
        return $this->where($column, 'LIKE', $value);
    }

    /**
     * Add an OR LIKE where clause
     */
    public function orWhereLike(string $column, string $value): self
    {
        return $this->orWhere($column, 'LIKE', $value);
    }

    /**
     * Add a conditional where clause
     *
     * Usage: when($hasFilter, fn($q) => $q->where('status', '=', $filter))
     */
    public function when(bool $condition, \Closure $callback, ?\Closure $default = null): self
    {
        if ($condition) {
            $callback($this);
        } elseif ($default !== null) {
            $default($this);
        }

        return $this;
    }

    /**
     * Add a where clause only if value is not null
     */
    public function whereIfNotNull(string $column, string $operator, $value): self
    {
        if ($value !== null) {
            $this->where($column, $operator, $value);
        }

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
        return $this->connection->fetchAll($sql, $this->getAllBindings());
    }

    public function first(): ?array
    {
        $sql = $this->buildSelectSql();
        return $this->connection->fetchOne($sql, $this->getAllBindings());
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

    /**
     * Process large datasets in chunks to avoid memory issues
     *
     * Usage: chunk(100, function($rows) { foreach ($rows as $row) { ... } })
     *
     * @param int $count Number of records per chunk
     * @param callable $callback Function to process each chunk, return false to stop
     * @return bool True if all chunks processed, false if stopped early
     */
    public function chunk(int $count, callable $callback): bool
    {
        $page = 1;

        do {
            // Clone state for each iteration
            $clonedQuery = clone $this;
            $clonedQuery->limit($count)->offset(($page - 1) * $count);

            $results = $clonedQuery->get();

            if (empty($results)) {
                break;
            }

            // Call the callback with the chunk of results
            if ($callback($results, $page) === false) {
                return false;
            }

            $page++;

            // Continue while we have full chunks
        } while (count($results) === $count);

        return true;
    }

    /**
     * Process records one by one using a generator
     *
     * Usage: foreach ($query->cursor() as $row) { ... }
     *
     * @param int $chunkSize Internal chunk size for fetching
     * @return \Generator
     */
    public function cursor(int $chunkSize = 100): \Generator
    {
        $page = 1;

        do {
            $clonedQuery = clone $this;
            $clonedQuery->limit($chunkSize)->offset(($page - 1) * $chunkSize);

            $results = $clonedQuery->get();

            foreach ($results as $result) {
                yield $result;
            }

            $page++;
        } while (count($results) === $chunkSize);
    }

    /**
     * Get the values of a single column
     *
     * Usage: pluck('name') returns ['John', 'Jane', ...]
     * Usage: pluck('name', 'id') returns [1 => 'John', 2 => 'Jane', ...]
     */
    public function pluck(string $column, ?string $key = null): array
    {
        $results = $this->get();

        $values = [];
        foreach ($results as $row) {
            if ($key !== null && isset($row[$key])) {
                $values[$row[$key]] = $row[$column] ?? null;
            } else {
                $values[] = $row[$column] ?? null;
            }
        }

        return $values;
    }

    /**
     * Get the value of a single column from the first row
     */
    public function value(string $column)
    {
        $result = $this->first();
        return $result[$column] ?? null;
    }

    /**
     * Add a UNION clause
     */
    public function union(self $query, bool $all = false): self
    {
        $type = $all ? 'UNION ALL' : 'UNION';

        $this->unions[] = [
            'type' => $type,
            'query' => $query,
        ];

        $this->unionBindings = array_merge($this->unionBindings, $query->getBindings());

        return $this;
    }

    /**
     * Add a UNION ALL clause
     */
    public function unionAll(self $query): self
    {
        return $this->union($query, true);
    }

    /**
     * Order by latest (created_at DESC)
     */
    public function latest(string $column = 'created_at'): self
    {
        return $this->orderBy($column, 'DESC');
    }

    /**
     * Order by oldest (created_at ASC)
     */
    public function oldest(string $column = 'created_at'): self
    {
        return $this->orderBy($column, 'ASC');
    }

    /**
     * Add random ordering
     */
    public function inRandomOrder(): self
    {
        $this->orders[] = ['column' => 'RAND()', 'direction' => ''];
        return $this;
    }

    /**
     * Take N records (alias for limit)
     */
    public function take(int $count): self
    {
        return $this->limit($count);
    }

    /**
     * Skip N records (alias for offset)
     */
    public function skip(int $count): self
    {
        return $this->offset($count);
    }

    /**
     * For pagination - get current page results with total count
     */
    public function forPage(int $page, int $perPage = 15): self
    {
        return $this->skip(($page - 1) * $perPage)->take($perPage);
    }

    /**
     * Get generated SQL query
     */
    public function toSql(): string
    {
        return $this->buildSelectSql();
    }

    /**
     * Get query bindings
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }

    /**
     * Get all bindings including union bindings
     */
    public function getAllBindings(): array
    {
        return array_merge($this->bindings, $this->unionBindings);
    }

    /**
     * Dump the query and bindings for debugging
     */
    public function dd(): void
    {
        echo "SQL: " . $this->toSql() . PHP_EOL;
        echo "Bindings: " . print_r($this->getAllBindings(), true);
        exit;
    }

    /**
     * Dump the query and bindings for debugging (without exiting)
     */
    public function dump(): self
    {
        echo "SQL: " . $this->toSql() . PHP_EOL;
        echo "Bindings: " . print_r($this->getAllBindings(), true);
        return $this;
    }

    /**
     * Create a new query builder with same connection
     */
    public function newQuery(): self
    {
        return new static($this->connection);
    }

    /**
     * Clone the query builder
     */
    public function clone(): self
    {
        return clone $this;
    }

    /**
     * Set the table using from() (alias for table())
     */
    public function from(string $table): self
    {
        return $this->table($table);
    }

    /**
     * Increment a column value
     */
    public function increment(string $column, int $amount = 1, array $extra = []): bool
    {
        $column = $this->sanitizeColumn($column);
        $data = array_merge([$column => new RawExpression("{$column} + {$amount}")], $extra);

        return $this->updateRaw($data);
    }

    /**
     * Decrement a column value
     */
    public function decrement(string $column, int $amount = 1, array $extra = []): bool
    {
        $column = $this->sanitizeColumn($column);
        $data = array_merge([$column => new RawExpression("{$column} - {$amount}")], $extra);

        return $this->updateRaw($data);
    }

    /**
     * Update with raw expressions
     */
    protected function updateRaw(array $data): bool
    {
        $sets = [];
        $bindings = [];

        foreach ($data as $column => $value) {
            $column = $this->sanitizeColumn($column);

            if ($value instanceof RawExpression) {
                $sets[] = "{$column} = {$value->getValue()}";
            } else {
                $sets[] = "{$column} = ?";
                $bindings[] = $value;
            }
        }

        $sets = implode(', ', $sets);
        $sql = "UPDATE {$this->table} SET {$sets}";

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
            $bindings = array_merge($bindings, $this->bindings);
        }

        return $this->connection->execute($sql, $bindings);
    }

    /**
     * Insert and get the last insert ID
     */
    public function insertGetId(array $data, string $sequence = 'id'): int|string|false
    {
        $sanitizedKeys = array_map(fn($col) => $this->sanitizeColumn($col), array_keys($data));
        $columns = implode(', ', $sanitizedKeys);
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        if ($this->connection->execute($sql, array_values($data))) {
            return $this->connection->lastInsertId();
        }

        return false;
    }

    /**
     * Insert multiple rows at once
     */
    public function insertBatch(array $rows): bool
    {
        if (empty($rows)) {
            return true;
        }

        // Get columns from first row
        $columns = array_keys($rows[0]);
        $sanitizedColumns = array_map(fn($col) => $this->sanitizeColumn($col), $columns);
        $columnsSql = implode(', ', $sanitizedColumns);

        // Build placeholders for each row
        $rowPlaceholders = '(' . implode(', ', array_fill(0, count($columns), '?')) . ')';
        $allPlaceholders = implode(', ', array_fill(0, count($rows), $rowPlaceholders));

        // Flatten values
        $bindings = [];
        foreach ($rows as $row) {
            foreach ($columns as $col) {
                $bindings[] = $row[$col] ?? null;
            }
        }

        $sql = "INSERT INTO {$this->table} ({$columnsSql}) VALUES {$allPlaceholders}";

        return $this->connection->execute($sql, $bindings);
    }

    /**
     * Insert or update (upsert) - MySQL specific
     */
    public function upsert(array $data, array $uniqueColumns, array $updateColumns): bool
    {
        $sanitizedKeys = array_map(fn($col) => $this->sanitizeColumn($col), array_keys($data));
        $columns = implode(', ', $sanitizedKeys);
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $updates = [];
        foreach ($updateColumns as $col) {
            $col = $this->sanitizeColumn($col);
            $updates[] = "{$col} = VALUES({$col})";
        }
        $updatesSql = implode(', ', $updates);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders}) ON DUPLICATE KEY UPDATE {$updatesSql}";

        return $this->connection->execute($sql, array_values($data));
    }

    /**
     * Truncate the table
     */
    public function truncate(): bool
    {
        return $this->connection->execute("TRUNCATE TABLE {$this->table}");
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
        $distinctKeyword = $this->distinct ? 'DISTINCT ' : '';
        $sql = "SELECT {$distinctKeyword}{$columns} FROM {$this->table}";

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

        // Handle unions
        if (!empty($this->unions)) {
            foreach ($this->unions as $union) {
                $sql .= " {$union['type']} " . $union['query']->toSql();
            }
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
            // Handle raw expressions like RAND()
            if ($order['direction'] === '') {
                $sql[] = $order['column'];
            } else {
                $sql[] = "{$order['column']} {$order['direction']}";
            }
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
