<?php
/**
 * File Path Component
 *
 * Displays file paths with icons.
 *
 * Usage:
 *   <?= filePath('app/Controllers/UserController.php') ?>
 *   <?= filePath('config/database.php') ?>
 */

/**
 * Render a file path with icon
 *
 * @param string $path File path
 * @param bool $highlight Whether to highlight the filename
 * @return string HTML output
 */
function filePath(string $path, bool $highlight = true): string
{
    $parts = explode('/', $path);
    $filename = array_pop($parts);
    $directory = implode('/', $parts);

    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $icon = getFileIconForPath($ext);

    if ($highlight && !empty($directory)) {
        return <<<HTML
<span class="file-path">
    <span class="mdi mdi-{$icon}"></span>
    <span class="file-path-segment">{$directory}/</span><span class="file-path-name">{$filename}</span>
</span>
HTML;
    }

    return <<<HTML
<span class="file-path">
    <span class="mdi mdi-{$icon}"></span>
    <span class="file-path-name">{$path}</span>
</span>
HTML;
}

/**
 * Render a folder path with icon
 *
 * @param string $path Folder path
 * @return string HTML output
 */
function folderPath(string $path): string
{
    $path = rtrim($path, '/');

    return <<<HTML
<span class="file-path">
    <span class="mdi mdi-folder"></span>
    <span class="file-path-name">{$path}/</span>
</span>
HTML;
}

/**
 * Get icon name for file extension
 *
 * @param string $ext File extension
 * @return string MDI icon name
 */
function getFileIconForPath(string $ext): string
{
    return match (strtolower($ext)) {
        'php' => 'language-php',
        'js' => 'language-javascript',
        'ts' => 'language-typescript',
        'json' => 'code-json',
        'css' => 'language-css3',
        'scss', 'sass' => 'sass',
        'html', 'htm' => 'language-html5',
        'md' => 'language-markdown',
        'sql' => 'database',
        'env' => 'cog',
        'yml', 'yaml' => 'file-cog',
        'xml' => 'xml',
        'sh', 'bash' => 'console',
        'py' => 'language-python',
        'rb' => 'language-ruby',
        'go' => 'language-go',
        'rs' => 'language-rust',
        'java' => 'language-java',
        'vue' => 'vuejs',
        'jsx', 'tsx' => 'react',
        'log' => 'text-box-outline',
        'lock' => 'lock',
        'gitignore' => 'git',
        '' => 'file-document-outline',
        default => 'file-document-outline',
    };
}
