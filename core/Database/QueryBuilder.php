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
        $this->columns = $columns;
        return $this;
    }

    public function where(string $column, string $operator, $value): self
    {
        $this->wheres[] = ['type' => 'basic', 'column' => $column, 'operator' => $operator, 'value' => $value, 'boolean' => 'and'];
        $this->bindings[] = $value;
        return $this;
    }

    public function orWhere(string $column, string $operator, $value): self
    {
        $this->wheres[] = ['type' => 'basic', 'column' => $column, 'operator' => $operator, 'value' => $value, 'boolean' => 'or'];
        $this->bindings[] = $value;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orders[] = ['column' => $column, 'direction' => strtoupper($direction)];
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

    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        return $this->connection->execute($sql, array_values($data));
    }

    public function update(array $data): bool
    {
        $sets = [];
        $bindings = [];

        foreach ($data as $column => $value) {
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

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ' . $this->buildWheres();
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

    protected function buildWheres(): string
    {
        $sql = [];

        foreach ($this->wheres as $i => $where) {
            $boolean = $i === 0 ? '' : " {$where['boolean']} ";
            $sql[] = "{$boolean}{$where['column']} {$where['operator']} ?";
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
}
