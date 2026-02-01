<?php

namespace Core\Database;

/**
 * Blueprint Class
 *
 * Provides a fluent interface for defining database table structure.
 */
class Blueprint
{
    protected string $table;
    protected array $columns = [];
    protected array $commands = [];
    protected string $engine = 'InnoDB';
    protected string $charset = 'utf8mb4';
    protected string $collation = 'utf8mb4_unicode_ci';

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Create auto-increment ID column (BIGINT UNSIGNED).
     */
    public function id(string $column = 'id'): self
    {
        $this->columns[] = "`{$column}` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY";
        return $this;
    }

    /**
     * Create a string column (VARCHAR).
     */
    public function string(string $column, int $length = 255): self
    {
        $this->columns[] = "`{$column}` VARCHAR({$length})";
        return $this;
    }

    /**
     * Create a text column.
     */
    public function text(string $column): self
    {
        $this->columns[] = "`{$column}` TEXT";
        return $this;
    }

    /**
     * Create an integer column.
     */
    public function integer(string $column): self
    {
        $this->columns[] = "`{$column}` INT";
        return $this;
    }

    /**
     * Create a big integer column.
     */
    public function bigInteger(string $column): self
    {
        $this->columns[] = "`{$column}` BIGINT";
        return $this;
    }

    /**
     * Create an unsigned big integer column (for foreign keys).
     */
    public function unsignedBigInteger(string $column): self
    {
        $this->columns[] = "`{$column}` BIGINT UNSIGNED";
        return $this;
    }

    /**
     * Create a boolean column (TINYINT).
     */
    public function boolean(string $column): self
    {
        $this->columns[] = "`{$column}` TINYINT(1)";
        return $this;
    }

    /**
     * Create a decimal column.
     */
    public function decimal(string $column, int $precision = 8, int $scale = 2): self
    {
        $this->columns[] = "`{$column}` DECIMAL({$precision}, {$scale})";
        return $this;
    }

    /**
     * Create a date column.
     */
    public function date(string $column): self
    {
        $this->columns[] = "`{$column}` DATE";
        return $this;
    }

    /**
     * Create a datetime column.
     */
    public function dateTime(string $column): self
    {
        $this->columns[] = "`{$column}` DATETIME";
        return $this;
    }

    /**
     * Create a timestamp column.
     */
    public function timestamp(string $column): self
    {
        $this->columns[] = "`{$column}` TIMESTAMP";
        return $this;
    }

    /**
     * Create created_at and updated_at timestamp columns.
     */
    public function timestamps(): self
    {
        $this->columns[] = "`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->columns[] = "`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        return $this;
    }

    /**
     * Create a soft delete column (deleted_at).
     */
    public function softDeletes(string $column = 'deleted_at'): self
    {
        $this->columns[] = "`{$column}` TIMESTAMP NULL DEFAULT NULL";
        return $this;
    }

    /**
     * Make the column nullable.
     */
    public function nullable(): self
    {
        if (!empty($this->columns)) {
            $lastIndex = count($this->columns) - 1;
            $this->columns[$lastIndex] .= " NULL";
        }
        return $this;
    }

    /**
     * Set default value for the column.
     */
    public function default($value): self
    {
        if (!empty($this->columns)) {
            $lastIndex = count($this->columns) - 1;
            $defaultValue = is_string($value) ? "'{$value}'" : $value;
            $this->columns[$lastIndex] .= " DEFAULT {$defaultValue}";
        }
        return $this;
    }

    /**
     * Make the column unsigned.
     */
    public function unsigned(): self
    {
        if (!empty($this->columns)) {
            $lastIndex = count($this->columns) - 1;
            $this->columns[$lastIndex] = str_replace('INT', 'INT UNSIGNED', $this->columns[$lastIndex]);
        }
        return $this;
    }

    /**
     * Create a unique index.
     */
    public function unique(string $column): self
    {
        $this->commands[] = "UNIQUE KEY `{$column}_unique` (`{$column}`)";
        return $this;
    }

    /**
     * Create an index.
     */
    public function index(string $column): self
    {
        $this->commands[] = "INDEX `{$column}_index` (`{$column}`)";
        return $this;
    }

    /**
     * Create a foreign key constraint.
     */
    public function foreign(string $column): ForeignKeyDefinition
    {
        return new ForeignKeyDefinition($this, $column);
    }

    /**
     * Add a foreign key command.
     */
    public function addForeignKey(string $column, string $references, string $on, string $onDelete = 'CASCADE', string $onUpdate = 'CASCADE'): self
    {
        $constraintName = "{$this->table}_{$column}_foreign";
        $this->commands[] = "CONSTRAINT `{$constraintName}` FOREIGN KEY (`{$column}`) REFERENCES `{$on}` (`{$references}`) ON DELETE {$onDelete} ON UPDATE {$onUpdate}";
        return $this;
    }

    /**
     * Build the CREATE TABLE SQL.
     */
    public function toSql(): string
    {
        $columns = array_merge($this->columns, $this->commands);
        $columnsSql = implode(",\n    ", $columns);

        return <<<SQL
CREATE TABLE `{$this->table}` (
    {$columnsSql}
) ENGINE={$this->engine} DEFAULT CHARSET={$this->charset} COLLATE={$this->collation};
SQL;
    }

    /**
     * Build the DROP TABLE SQL.
     */
    public function dropSql(): string
    {
        return "DROP TABLE IF EXISTS `{$this->table}`;";
    }
}

/**
 * Foreign Key Definition Helper
 */
class ForeignKeyDefinition
{
    protected Blueprint $blueprint;
    protected string $column;
    protected ?string $referencedColumn = null;
    protected ?string $referencedTable = null;
    protected string $onDeleteAction = 'CASCADE';
    protected string $onUpdateAction = 'CASCADE';

    public function __construct(Blueprint $blueprint, string $column)
    {
        $this->blueprint = $blueprint;
        $this->column = $column;
    }

    /**
     * Specify the referenced table and column.
     */
    public function references(string $column): self
    {
        $this->referencedColumn = $column;
        return $this;
    }

    /**
     * Specify the referenced table.
     */
    public function on(string $table): self
    {
        $this->referencedTable = $table;
        $this->blueprint->addForeignKey(
            $this->column,
            $this->referencedColumn ?? 'id',
            $table,
            $this->onDeleteAction,
            $this->onUpdateAction
        );
        return $this;
    }

    /**
     * Set ON DELETE action.
     */
    public function onDelete(string $action): self
    {
        $this->onDeleteAction = strtoupper($action);
        return $this;
    }

    /**
     * Set ON UPDATE action.
     */
    public function onUpdate(string $action): self
    {
        $this->onUpdateAction = strtoupper($action);
        return $this;
    }
}
