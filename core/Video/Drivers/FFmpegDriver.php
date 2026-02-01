<?php

namespace Core\Video\Drivers;

/**
 * FFmpegDriver
 *
 * FFmpeg-based video processing driver.
 * Provides low-level FFmpeg command execution for video operations.
 *
 * Requirements:
 * - FFmpeg binary installed on the system
 * - FFprobe binary for metadata extraction
 *
 * Usage:
 * ```php
 * $driver = new FFmpegDriver();
 *
 * if ($driver->isAvailable()) {
 *     $driver->extractFrame('/path/video.mp4', '/path/thumb.jpg', 5.0);
 *     $metadata = $driver->getMetadata('/path/video.mp4');
 * }
 * ```
 */
class FFmpegDriver
{
    /**
     * Path to FFmpeg binary
     */
    protected string $ffmpegPath;

    /**
     * Path to FFprobe binary
     */
    protected string $ffprobePath;

    /**
     * Timeout for commands (seconds)
     */
    protected int $timeout;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ffmpegPath = config('media.video.ffmpeg_path', '/usr/bin/ffmpeg');
        $this->ffprobePath = config('media.video.ffprobe_path', '/usr/bin/ffprobe');
        $this->timeout = config('media.video.timeout', 300);
    }

    /**
     * Check if FFmpeg is available
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->isExecutable($this->ffmpegPath) && $this->isExecutable($this->ffprobePath);
    }

    /**
     * Check if a binary is executable
     *
     * @param string $path Path to binary
     * @return bool
     */
    protected function isExecutable(string $path): bool
    {
        if (!file_exists($path)) {
            // Try which command
            $output = shell_exec("which " . basename($path) . " 2>/dev/null");
            return !empty(trim($output ?? ''));
        }

        return is_executable($path);
    }

    /**
     * Extract a single frame from video
     *
     * @param string $input Input video path
     * @param string $output Output image path
     * @param float $time Time position in seconds
     * @param int $width Output width (height auto-calculated)
     * @param int $quality JPEG quality (1-31, lower is better)
     * @return bool True if successful
     */
    public function extractFrame(
        string $input,
        string $output,
        float $time = 1.0,
        ?int $width = null,
        int $quality = 2
    ): bool {
        // Build scale filter
        $scaleFilter = $width ? "-vf scale={$width}:-1" : '';

        $command = sprintf(
            '%s -ss %f -i %s %s -vframes 1 -q:v %d %s -y 2>&1',
            escapeshellcmd($this->ffmpegPath),
            $time,
            escapeshellarg($input),
            $scaleFilter,
            $quality,
            escapeshellarg($output)
        );

        $this->execute($command, $outputLines, $returnCode);

        return $returnCode === 0 && file_exists($output);
    }

    /**
     * Extract multiple frames at intervals
     *
     * @param string $input Input video path
     * @param string $outputDir Output directory
     * @param string $pattern Output filename pattern (e.g., 'thumb_%03d.jpg')
     * @param int $count Number of frames to extract
     * @param float|null $duration Video duration (auto-detected if null)
     * @return array Array of generated file paths
     */
    public function extractFrames(
        string $input,
        string $outputDir,
        string $pattern = 'frame_%03d.jpg',
        int $count = 5,
        ?float $duration = null
    ): array {
        // Get duration if not provided
        if ($duration === null) {
            $metadata = $this->getMetadata($input);
            $duration = $metadata['duration'] ?? 0;
        }

        if ($duration <= 0) {
            return [];
        }

        // Ensure output directory exists
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $frames = [];
        $interval = $duration / ($count + 1);

        for ($i = 1; $i <= $count; $i++) {
            $time = $interval * $i;
            $filename = sprintf($pattern, $i);
            $outputPath = rtrim($outputDir, '/') . '/' . sprintf('frame_%03d.jpg', $i);

            if ($this->extractFrame($input, $outputPath, $time)) {
                $frames[] = $outputPath;
            }
        }

        return $frames;
    }

    /**
     * Get video metadata
     *
     * @param string $input Video path
     * @return array Metadata (duration, width, height, codec, bitrate, etc.)
     */
    public function getMetadata(string $input): array
    {
        $command = sprintf(
            '%s -v quiet -print_format json -show_format -show_streams %s 2>&1',
            escapeshellcmd($this->ffprobePath),
            escapeshellarg($input)
        );

        $this->execute($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return [];
        }

        $json = implode("\n", $output);
        $data = json_decode($json, true);

        if (!$data) {
            return [];
        }

        $metadata = [
            'duration' => 0,
            'width' => 0,
            'height' => 0,
            'codec' => null,
            'bitrate' => 0,
            'fps' => 0,
            'audio_codec' => null,
            'audio_channels' => 0,
            'audio_sample_rate' => 0,
        ];

        // Format info
        if (isset($data['format'])) {
            $metadata['duration'] = (float) ($data['format']['duration'] ?? 0);
            $metadata['bitrate'] = (int) ($data['format']['bit_rate'] ?? 0);
        }

        // Stream info
        if (isset($data['streams'])) {
            foreach ($data['streams'] as $stream) {
                if ($stream['codec_type'] === 'video') {
                    $metadata['width'] = (int) ($stream['width'] ?? 0);
                    $metadata['height'] = (int) ($stream['height'] ?? 0);
                    $metadata['codec'] = $stream['codec_name'] ?? null;

                    // Calculate FPS
                    if (isset($stream['r_frame_rate'])) {
                        $parts = explode('/', $stream['r_frame_rate']);
                        if (count($parts) === 2 && $parts[1] > 0) {
                            $metadata['fps'] = round($parts[0] / $parts[1], 2);
                        }
                    }
                } elseif ($stream['codec_type'] === 'audio') {
                    $metadata['audio_codec'] = $stream['codec_name'] ?? null;
                    $metadata['audio_channels'] = (int) ($stream['channels'] ?? 0);
                    $metadata['audio_sample_rate'] = (int) ($stream['sample_rate'] ?? 0);
                }
            }
        }

        return $metadata;
    }

    /**
     * Generate animated GIF preview
     *
     * @param string $input Input video path
     * @param string $output Output GIF path
     * @param array $options Options (width, fps, duration, start)
     * @return bool True if successful
     */
    public function generateGif(string $input, string $output, array $options = []): bool
    {
        $width = $options['width'] ?? 320;
        $fps = $options['fps'] ?? 10;
        $duration = $options['duration'] ?? 5;
        $start = $options['start'] ?? 0;

        // Create palette for better quality
        $palettePath = sys_get_temp_dir() . '/palette_' . uniqid() . '.png';

        // Generate palette
        $paletteCmd = sprintf(
            '%s -ss %f -t %f -i %s -vf "fps=%d,scale=%d:-1:flags=lanczos,palettegen" -y %s 2>&1',
            escapeshellcmd($this->ffmpegPath),
            $start,
            $duration,
            escapeshellarg($input),
            $fps,
            $width,
            escapeshellarg($palettePath)
        );

        $this->execute($paletteCmd, $paletteOutput, $paletteReturnCode);

        if ($paletteReturnCode !== 0 || !file_exists($palettePath)) {
            return false;
        }

        // Generate GIF with palette
        $gifCmd = sprintf(
            '%s -ss %f -t %f -i %s -i %s -filter_complex "fps=%d,scale=%d:-1:flags=lanczos[x];[x][1:v]paletteuse" -y %s 2>&1',
            escapeshellcmd($this->ffmpegPath),
            $start,
            $duration,
            escapeshellarg($input),
            escapeshellarg($palettePath),
            $fps,
            $width,
            escapeshellarg($output)
        );

        $this->execute($gifCmd, $gifOutput, $gifReturnCode);

        // Cleanup palette
        @unlink($palettePath);

        return $gifReturnCode === 0 && file_exists($output);
    }

    /**
     * Generate video thumbnail sprite (for video scrubbing)
     *
     * @param string $input Input video path
     * @param string $output Output sprite image path
     * @param int $columns Number of columns in sprite
     * @param int $rows Number of rows in sprite
     * @param int $thumbWidth Width of each thumbnail
     * @return array Sprite info (path, columns, rows, interval)
     */
    public function generateSprite(
        string $input,
        string $output,
        int $columns = 10,
        int $rows = 10,
        int $thumbWidth = 160
    ): array {
        $metadata = $this->getMetadata($input);
        $duration = $metadata['duration'] ?? 0;

        if ($duration <= 0) {
            return [];
        }

        $totalFrames = $columns * $rows;
        $interval = $duration / $totalFrames;

        // Generate sprite using ffmpeg
        $command = sprintf(
            '%s -i %s -vf "fps=1/%f,scale=%d:-1,tile=%dx%d" -frames:v 1 -y %s 2>&1',
            escapeshellcmd($this->ffmpegPath),
            escapeshellarg($input),
            $interval,
            $thumbWidth,
            $columns,
            $rows,
            escapeshellarg($output)
        );

        $this->execute($command, $outputLines, $returnCode);

        if ($returnCode !== 0 || !file_exists($output)) {
            return [];
        }

        return [
            'path' => $output,
            'columns' => $columns,
            'rows' => $rows,
            'interval' => $interval,
            'thumb_width' => $thumbWidth,
            'total_frames' => $totalFrames,
        ];
    }

    /**
     * Convert video format
     *
     * @param string $input Input video path
     * @param string $output Output video path
     * @param array $options Conversion options
     * @return bool True if successful
     */
    public function convert(string $input, string $output, array $options = []): bool
    {
        $videoCodec = $options['video_codec'] ?? 'libx264';
        $audioCodec = $options['audio_codec'] ?? 'aac';
        $crf = $options['crf'] ?? 23;
        $preset = $options['preset'] ?? 'medium';

        $command = sprintf(
            '%s -i %s -c:v %s -crf %d -preset %s -c:a %s -y %s 2>&1',
            escapeshellcmd($this->ffmpegPath),
            escapeshellarg($input),
            $videoCodec,
            $crf,
            $preset,
            $audioCodec,
            escapeshellarg($output)
        );

        $this->execute($command, $outputLines, $returnCode, $this->timeout);

        return $returnCode === 0 && file_exists($output);
    }

    /**
     * Execute command with timeout
     *
     * @param string $command Command to execute
     * @param array &$output Command output
     * @param int &$returnCode Return code
     * @param int|null $timeout Timeout in seconds
     */
    protected function execute(string $command, &$output, &$returnCode, ?int $timeout = null): void
    {
        $timeout = $timeout ?? 60;

        // Set process limits
        $command = "timeout {$timeout} {$command}";

        exec($command, $output, $returnCode);
    }

    /**
     * Get FFmpeg version
     *
     * @return string|null Version string or null if not available
     */
    public function getVersion(): ?string
    {
        if (!$this->isAvailable()) {
            return null;
        }

        $command = sprintf('%s -version 2>&1', escapeshellcmd($this->ffmpegPath));
        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || empty($output)) {
            return null;
        }

        // Parse version from first line
        if (preg_match('/ffmpeg version (\S+)/', $output[0], $matches)) {
            return $matches[1];
        }

        return null;
    }
}
