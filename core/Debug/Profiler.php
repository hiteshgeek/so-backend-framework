<?php

namespace Core\Debug;

/**
 * Profiler
 *
 * Tracks application performance metrics, database queries, and execution timeline.
 * Useful for debugging and optimization during development.
 */
class Profiler
{
    /**
     * Profiler instance
     */
    protected static ?self $instance = null;

    /**
     * Whether profiling is enabled
     */
    protected bool $enabled = false;

    /**
     * Request start time
     */
    protected float $startTime;

    /**
     * Request start memory
     */
    protected int $startMemory;

    /**
     * Database queries
     */
    protected array $queries = [];

    /**
     * Timeline events
     */
    protected array $timeline = [];

    /**
     * Custom metrics
     */
    protected array $metrics = [];

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->enabled = config('app.debug', false);
        $this->startTime = defined('APP_START') ? APP_START : microtime(true);
        $this->startMemory = memory_get_usage();
    }

    /**
     * Get profiler instance
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Check if profiling is enabled
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Enable profiling
     */
    public function enable(): void
    {
        $this->enabled = true;
    }

    /**
     * Disable profiling
     */
    public function disable(): void
    {
        $this->enabled = false;
    }

    /**
     * Add a database query to the profiler
     */
    public function addQuery(string $sql, array $bindings = [], float $time = 0): void
    {
        if (!$this->enabled) {
            return;
        }

        $this->queries[] = [
            'sql' => $sql,
            'bindings' => $bindings,
            'time' => $time,
            'timestamp' => microtime(true),
        ];
    }

    /**
     * Get all tracked queries
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    /**
     * Get query count
     */
    public function getQueryCount(): int
    {
        return count($this->queries);
    }

    /**
     * Get total query time
     */
    public function getTotalQueryTime(): float
    {
        return array_sum(array_column($this->queries, 'time'));
    }

    /**
     * Add a timeline event
     */
    public function addEvent(string $name, string $category = 'general'): void
    {
        if (!$this->enabled) {
            return;
        }

        $this->timeline[] = [
            'name' => $name,
            'category' => $category,
            'time' => microtime(true),
            'memory' => memory_get_usage(),
        ];
    }

    /**
     * Get timeline events
     */
    public function getTimeline(): array
    {
        return $this->timeline;
    }

    /**
     * Start a timer
     */
    public function startTimer(string $name): void
    {
        if (!$this->enabled) {
            return;
        }

        $this->metrics[$name]['start'] = microtime(true);
    }

    /**
     * Stop a timer
     */
    public function stopTimer(string $name): float
    {
        if (!$this->enabled || !isset($this->metrics[$name]['start'])) {
            return 0;
        }

        $duration = microtime(true) - $this->metrics[$name]['start'];
        $this->metrics[$name]['duration'] = $duration;

        return $duration;
    }

    /**
     * Get timer duration
     */
    public function getTimer(string $name): ?float
    {
        return $this->metrics[$name]['duration'] ?? null;
    }

    /**
     * Add a custom metric
     */
    public function addMetric(string $name, mixed $value): void
    {
        if (!$this->enabled) {
            return;
        }

        $this->metrics[$name] = $value;
    }

    /**
     * Get all metrics
     */
    public function getMetrics(): array
    {
        return $this->metrics;
    }

    /**
     * Get execution time
     */
    public function getExecutionTime(): float
    {
        return microtime(true) - $this->startTime;
    }

    /**
     * Get memory usage
     */
    public function getMemoryUsage(): int
    {
        return memory_get_usage() - $this->startMemory;
    }

    /**
     * Get peak memory usage
     */
    public function getPeakMemoryUsage(): int
    {
        return memory_get_peak_usage();
    }

    /**
     * Format bytes to human-readable size
     */
    public function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Get profiler summary
     */
    public function getSummary(): array
    {
        return [
            'execution_time' => round($this->getExecutionTime() * 1000, 2), // ms
            'memory_usage' => $this->formatBytes($this->getMemoryUsage()),
            'peak_memory' => $this->formatBytes($this->getPeakMemoryUsage()),
            'query_count' => $this->getQueryCount(),
            'total_query_time' => round($this->getTotalQueryTime() * 1000, 2), // ms
            'timeline_events' => count($this->timeline),
            'custom_metrics' => count($this->metrics),
        ];
    }

    /**
     * Get detailed report
     */
    public function getReport(): array
    {
        return [
            'summary' => $this->getSummary(),
            'queries' => $this->getQueries(),
            'timeline' => $this->getTimeline(),
            'metrics' => $this->getMetrics(),
        ];
    }

    /**
     * Render profiler output
     */
    public function render(): string
    {
        if (!$this->enabled) {
            return '';
        }

        $summary = $this->getSummary();
        $queries = $this->getQueries();

        ob_start();
        ?>
        <style>
            .profiler-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #1a202c;
                color: #e2e8f0;
                padding: 12px 20px;
                font-family: 'Courier New', monospace;
                font-size: 12px;
                z-index: 9999;
                box-shadow: 0 -2px 10px rgba(0,0,0,0.3);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .profiler-metrics {
                display: flex;
                gap: 24px;
            }
            .profiler-metric {
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .profiler-label {
                color: #a0aec0;
                font-weight: 600;
            }
            .profiler-value {
                color: #48bb78;
                font-weight: bold;
            }
            .profiler-value.warning {
                color: #f6ad55;
            }
            .profiler-value.danger {
                color: #fc8181;
            }
            .profiler-toggle {
                background: #2d3748;
                border: none;
                color: #e2e8f0;
                padding: 6px 12px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 11px;
                font-weight: bold;
            }
            .profiler-toggle:hover {
                background: #4a5568;
            }
            .profiler-details {
                display: none;
                position: fixed;
                bottom: 50px;
                left: 20px;
                right: 20px;
                max-height: 60vh;
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                overflow-y: auto;
                z-index: 9998;
                padding: 20px;
            }
            .profiler-details.active {
                display: block;
            }
            .profiler-details h3 {
                margin-top: 0;
                color: #2d3748;
            }
            .profiler-query {
                background: #f7fafc;
                padding: 12px;
                margin-bottom: 8px;
                border-left: 3px solid #4299e1;
                border-radius: 4px;
            }
            .profiler-query-sql {
                font-family: 'Courier New', monospace;
                color: #2d3748;
                margin-bottom: 6px;
            }
            .profiler-query-meta {
                display: flex;
                gap: 16px;
                font-size: 11px;
                color: #718096;
            }
        </style>

        <div class="profiler-bar">
            <div class="profiler-metrics">
                <div class="profiler-metric">
                    <span class="profiler-label">Time:</span>
                    <span class="profiler-value <?= $summary['execution_time'] > 1000 ? 'warning' : '' ?>">
                        <?= $summary['execution_time'] ?>ms
                    </span>
                </div>
                <div class="profiler-metric">
                    <span class="profiler-label">Memory:</span>
                    <span class="profiler-value">
                        <?= $summary['memory_usage'] ?> / <?= $summary['peak_memory'] ?>
                    </span>
                </div>
                <div class="profiler-metric">
                    <span class="profiler-label">Queries:</span>
                    <span class="profiler-value <?= $summary['query_count'] > 20 ? 'warning' : '' ?>">
                        <?= $summary['query_count'] ?> (<?= $summary['total_query_time'] ?>ms)
                    </span>
                </div>
                <div class="profiler-metric">
                    <span class="profiler-label">Events:</span>
                    <span class="profiler-value"><?= $summary['timeline_events'] ?></span>
                </div>
            </div>
            <button class="profiler-toggle" onclick="document.querySelector('.profiler-details').classList.toggle('active')">
                Toggle Details
            </button>
        </div>

        <div class="profiler-details">
            <h3>Database Queries (<?= count($queries) ?>)</h3>
            <?php foreach ($queries as $i => $query): ?>
                <div class="profiler-query">
                    <div class="profiler-query-sql">
                        <?= htmlspecialchars($query['sql']) ?>
                    </div>
                    <div class="profiler-query-meta">
                        <span><strong>Time:</strong> <?= round($query['time'] * 1000, 2) ?>ms</span>
                        <?php if (!empty($query['bindings'])): ?>
                            <span><strong>Bindings:</strong> <?= htmlspecialchars(json_encode($query['bindings'])) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($queries)): ?>
                <p style="color: #718096;">No database queries executed.</p>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
