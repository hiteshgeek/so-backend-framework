<?php

namespace Core\Logging;

/**
 * Logger
 *
 * PSR-3 inspired logging with file, daily, and syslog drivers.
 * Supports multiple channels, log levels, and context interpolation.
 *
 * Usage:
 *   $logger = new Logger($config);
 *   $logger->error('Something failed', ['exception' => $e]);
 *   $logger->info('User logged in', ['user_id' => 42]);
 */
class Logger
{
    /**
     * Log levels (RFC 5424)
     */
    public const EMERGENCY = 'emergency';
    public const ALERT     = 'alert';
    public const CRITICAL  = 'critical';
    public const ERROR     = 'error';
    public const WARNING   = 'warning';
    public const NOTICE    = 'notice';
    public const INFO      = 'info';
    public const DEBUG     = 'debug';

    /**
     * Level priority (lower = more severe)
     */
    protected const LEVEL_PRIORITY = [
        self::EMERGENCY => 0,
        self::ALERT     => 1,
        self::CRITICAL  => 2,
        self::ERROR     => 3,
        self::WARNING   => 4,
        self::NOTICE    => 5,
        self::INFO      => 6,
        self::DEBUG     => 7,
    ];

    protected array $config;
    protected string $defaultChannel;
    protected array $channels = [];

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->defaultChannel = $config['default'] ?? 'daily';
    }

    /**
     * Get a channel instance
     */
    public function channel(?string $name = null): self
    {
        $clone = clone $this;
        $clone->defaultChannel = $name ?? $this->defaultChannel;
        return $clone;
    }

    /**
     * Log an emergency message
     */
    public function emergency(string $message, array $context = []): void
    {
        $this->log(self::EMERGENCY, $message, $context);
    }

    /**
     * Log an alert message
     */
    public function alert(string $message, array $context = []): void
    {
        $this->log(self::ALERT, $message, $context);
    }

    /**
     * Log a critical message
     */
    public function critical(string $message, array $context = []): void
    {
        $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Log an error message
     */
    public function error(string $message, array $context = []): void
    {
        $this->log(self::ERROR, $message, $context);
    }

    /**
     * Log a warning message
     */
    public function warning(string $message, array $context = []): void
    {
        $this->log(self::WARNING, $message, $context);
    }

    /**
     * Log a notice message
     */
    public function notice(string $message, array $context = []): void
    {
        $this->log(self::NOTICE, $message, $context);
    }

    /**
     * Log an info message
     */
    public function info(string $message, array $context = []): void
    {
        $this->log(self::INFO, $message, $context);
    }

    /**
     * Log a debug message
     */
    public function debug(string $message, array $context = []): void
    {
        $this->log(self::DEBUG, $message, $context);
    }

    /**
     * Log a message at the given level
     */
    public function log(string $level, string $message, array $context = []): void
    {
        $channelConfig = $this->resolveChannelConfig($this->defaultChannel);
        $driver = $channelConfig['driver'] ?? 'daily';
        $minLevel = $channelConfig['level'] ?? self::DEBUG;

        // Skip if message level is less severe than channel minimum
        if (self::LEVEL_PRIORITY[$level] > self::LEVEL_PRIORITY[$minLevel]) {
            return;
        }

        $formatted = $this->formatMessage($level, $message, $context);

        match ($driver) {
            'single' => $this->writeToSingle($channelConfig, $formatted),
            'daily'  => $this->writeToDaily($channelConfig, $formatted),
            'syslog' => $this->writeToSyslog($channelConfig, $level, $formatted),
            'stderr' => $this->writeToStderr($formatted),
            default  => $this->writeToDaily($channelConfig, $formatted),
        };
    }

    /**
     * Format a log message
     */
    protected function formatMessage(string $level, string $message, array $context): string
    {
        $timestamp = date('Y-m-d H:i:s');
        $level = strtoupper($level);

        // Interpolate context placeholders in message
        $message = $this->interpolate($message, $context);

        // Build context string
        $contextStr = '';
        if (!empty($context)) {
            $contextStr = ' ' . json_encode($this->normalizeContext($context), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return "[{$timestamp}] {$level}: {$message}{$contextStr}" . PHP_EOL;
    }

    /**
     * Interpolate context values into message placeholders
     */
    protected function interpolate(string $message, array $context): string
    {
        $replace = [];
        foreach ($context as $key => $val) {
            if (is_string($val) || is_numeric($val)) {
                $replace['{' . $key . '}'] = $val;
            }
        }
        return strtr($message, $replace);
    }

    /**
     * Normalize context for JSON encoding
     */
    protected function normalizeContext(array $context): array
    {
        $normalized = [];

        foreach ($context as $key => $value) {
            if ($value instanceof \Throwable) {
                $normalized[$key] = [
                    'class' => get_class($value),
                    'message' => $value->getMessage(),
                    'code' => $value->getCode(),
                    'file' => $value->getFile() . ':' . $value->getLine(),
                    'trace' => array_slice(
                        array_map(fn($t) => ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?') . ' ' . ($t['class'] ?? '') . ($t['type'] ?? '') . ($t['function'] ?? ''),
                            $value->getTrace()
                    ), 0, 10),
                ];
            } elseif (is_object($value)) {
                $normalized[$key] = get_class($value) . (method_exists($value, '__toString') ? ': ' . (string)$value : '');
            } elseif (is_array($value)) {
                $normalized[$key] = $this->normalizeContext($value);
            } else {
                $normalized[$key] = $value;
            }
        }

        return $normalized;
    }

    /**
     * Write to a single log file
     */
    protected function writeToSingle(array $config, string $formatted): void
    {
        $path = $config['path'] ?? storage_path('logs/app.log');
        $this->ensureDirectoryExists($path);
        file_put_contents($path, $formatted, FILE_APPEND | LOCK_EX);
    }

    /**
     * Write to a daily rotated log file
     */
    protected function writeToDaily(array $config, string $formatted): void
    {
        $basePath = $config['path'] ?? storage_path('logs/app.log');
        $dir = dirname($basePath);
        $ext = pathinfo($basePath, PATHINFO_EXTENSION);
        $name = pathinfo($basePath, PATHINFO_FILENAME);

        $path = $dir . '/' . $name . '-' . date('Y-m-d') . '.' . $ext;
        $this->ensureDirectoryExists($path);
        file_put_contents($path, $formatted, FILE_APPEND | LOCK_EX);

        // Clean old logs
        $days = $config['days'] ?? 14;
        $this->cleanOldLogs($dir, $name, $ext, $days);
    }

    /**
     * Write to syslog
     */
    protected function writeToSyslog(array $config, string $level, string $formatted): void
    {
        $facility = $config['facility'] ?? LOG_USER;
        $ident = $config['ident'] ?? 'so-framework';

        openlog($ident, LOG_PID, $facility);

        $priority = match ($level) {
            self::EMERGENCY => LOG_EMERG,
            self::ALERT     => LOG_ALERT,
            self::CRITICAL  => LOG_CRIT,
            self::ERROR     => LOG_ERR,
            self::WARNING   => LOG_WARNING,
            self::NOTICE    => LOG_NOTICE,
            self::INFO      => LOG_INFO,
            self::DEBUG     => LOG_DEBUG,
            default         => LOG_INFO,
        };

        syslog($priority, trim($formatted));
        closelog();
    }

    /**
     * Write to stderr
     */
    protected function writeToStderr(string $formatted): void
    {
        file_put_contents('php://stderr', $formatted);
    }

    /**
     * Ensure the directory for a file path exists
     */
    protected function ensureDirectoryExists(string $filePath): void
    {
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    /**
     * Clean old daily log files beyond retention period
     */
    protected function cleanOldLogs(string $dir, string $name, string $ext, int $days): void
    {
        // Only run cleanup ~1% of the time to avoid filesystem overhead
        if (mt_rand(1, 100) > 1) {
            return;
        }

        $cutoff = strtotime("-{$days} days");
        $pattern = $dir . '/' . $name . '-*.'. $ext;

        foreach (glob($pattern) as $file) {
            if (filemtime($file) < $cutoff) {
                @unlink($file);
            }
        }
    }

    /**
     * Resolve channel configuration
     */
    protected function resolveChannelConfig(string $name): array
    {
        return $this->config['channels'][$name] ?? [
            'driver' => 'daily',
            'path' => storage_path('logs/app.log'),
            'level' => self::DEBUG,
            'days' => 14,
        ];
    }
}
