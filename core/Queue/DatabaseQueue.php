<?php

namespace Core\Queue;

use Core\Database\Connection;

/**
 * Database Queue Driver
 *
 * Stores jobs in the database for processing
 */
class DatabaseQueue
{
    protected Connection $connection;
    protected string $table;
    protected string $queue;
    protected int $retryAfter;

    public function __construct(Connection $connection, array $config = [])
    {
        $this->connection = $connection;
        $this->table = $config['table'] ?? 'jobs';
        $this->queue = $config['queue'] ?? 'default';
        $this->retryAfter = $config['retry_after'] ?? 90;
    }

    /**
     * Push a job onto the queue
     */
    public function push(Job $job, ?string $queue = null): string
    {
        $queue = $queue ?? $job->queue ?? $this->queue;
        $payload = $job->serialize();

        $jobId = $this->insertJob($queue, $payload, 0, time());

        $job->jobId = (string)$jobId;

        return (string)$jobId;
    }

    /**
     * Push a job onto the queue with a delay
     */
    public function later(Job $job, int $delay, ?string $queue = null): string
    {
        $queue = $queue ?? $job->queue ?? $this->queue;
        $payload = $job->serialize();

        $availableAt = time() + $delay;
        $jobId = $this->insertJob($queue, $payload, 0, $availableAt);

        $job->jobId = (string)$jobId;

        return (string)$jobId;
    }

    /**
     * Pop the next job off the queue
     */
    public function pop(?string $queue = null): ?Job
    {
        $queue = $queue ?? $this->queue;

        // Get the next available job with row locking
        $sql = "SELECT * FROM {$this->table}
                WHERE queue = ?
                AND available_at <= ?
                AND (reserved_at IS NULL OR reserved_at < ?)
                ORDER BY id ASC
                LIMIT 1
                FOR UPDATE";

        $now = time();
        $expiration = $now - $this->retryAfter;

        $this->connection->beginTransaction();

        try {
            $stmt = $this->connection->query($sql, [$queue, $now, $expiration]);

            // Handle PDOStatement return
            if ($stmt instanceof \PDOStatement) {
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                $result = $stmt;
            }

            if (empty($result)) {
                $this->connection->commit();
                return null;
            }

            $jobData = $result[0];

            // Reserve the job
            $updateSql = "UPDATE {$this->table}
                          SET reserved_at = ?, attempts = attempts + 1
                          WHERE id = ?";

            $this->connection->execute($updateSql, [$now, $jobData['id']]);

            $this->connection->commit();

            // Unserialize the job
            $job = Job::unserialize($jobData['payload']);
            $job->jobId = (string)$jobData['id'];
            $job->setAttempts((int)$jobData['attempts'] + 1);

            return $job;

        } catch (\Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    /**
     * Delete a job from the queue
     */
    public function delete(string $jobId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->connection->execute($sql, [$jobId]) > 0;
    }

    /**
     * Release a job back onto the queue
     */
    public function release(Job $job, int $delay = 0): void
    {
        if (!$job->jobId) {
            return;
        }

        $availableAt = time() + $delay;

        $sql = "UPDATE {$this->table}
                SET reserved_at = NULL, available_at = ?
                WHERE id = ?";

        $this->connection->execute($sql, [$availableAt, $job->jobId]);
    }

    /**
     * Move a failed job to the failed jobs table
     */
    public function failed(Job $job, \Exception $exception): void
    {
        $uuid = $this->generateUuid();

        $sql = "INSERT INTO failed_jobs (uuid, connection, queue, payload, exception, failed_at)
                VALUES (?, ?, ?, ?, ?, ?)";

        $this->connection->execute($sql, [
            $uuid,
            'database',
            $job->queue ?? $this->queue,
            $job->serialize(),
            $this->formatException($exception),
            date('Y-m-d H:i:s'),
        ]);

        // Delete from jobs table
        if ($job->jobId) {
            $this->delete($job->jobId);
        }
    }

    /**
     * Insert a job into the queue
     */
    protected function insertJob(string $queue, string $payload, int $attempts, int $availableAt): int
    {
        $sql = "INSERT INTO {$this->table} (queue, payload, attempts, available_at, created_at)
                VALUES (?, ?, ?, ?, ?)";

        $this->connection->execute($sql, [
            $queue,
            $payload,
            $attempts,
            $availableAt,
            time(),
        ]);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Format exception for storage
     */
    protected function formatException(\Exception $exception): string
    {
        return sprintf(
            "%s: %s in %s:%d\nStack trace:\n%s",
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
    }

    /**
     * Generate a UUID for failed jobs
     */
    protected function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Get the size of the queue
     */
    public function size(?string $queue = null): int
    {
        $queue = $queue ?? $this->queue;

        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE queue = ?";
        $stmt = $this->connection->query($sql, [$queue]);

        if ($stmt instanceof \PDOStatement) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return (int)($result[0]['count'] ?? 0);
        }

        return (int)($stmt[0]['count'] ?? 0);
    }
}
