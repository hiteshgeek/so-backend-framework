<?php

namespace Core\Database;

use PDO;
use PDOException;

/**
 * Database Connection
 */
class Connection
{
    protected ?PDO $pdo = null;
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function connect(): PDO
    {
        if ($this->pdo !== null) {
            return $this->pdo;
        }

        try {
            $driver = $this->config['driver'] ?? 'mysql';
            $host = $this->config['host'] ?? 'localhost';
            $port = $this->config['port'] ?? 3306;
            $database = $this->config['database'];
            $username = $this->config['username'];
            $password = $this->config['password'] ?? '';

            $dsn = "{$driver}:host={$host};port={$port};dbname={$database};charset=utf8mb4";

            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            return $this->pdo;
        } catch (PDOException $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    public function getPdo(): PDO
    {
        return $this->connect();
    }

    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();
        return $result ?: null;
    }

    public function execute(string $sql, array $params = []): bool
    {
        return $this->query($sql, $params)->rowCount() > 0;
    }

    public function lastInsertId(): string
    {
        return $this->getPdo()->lastInsertId();
    }

    public function beginTransaction(): bool
    {
        return $this->getPdo()->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->getPdo()->commit();
    }

    public function rollBack(): bool
    {
        return $this->getPdo()->rollBack();
    }

    public function table(string $table): QueryBuilder
    {
        return (new QueryBuilder($this))->table($table);
    }
}
