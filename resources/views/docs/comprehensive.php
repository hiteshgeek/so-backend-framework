<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Documentation') ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: #f5f5f5;
            line-height: 1.6;
        }

        /* Offset for sticky header */
        .markdown h2::before,
        .markdown h3::before,
        .markdown h4::before {
            content: "";
            display: block;
            height: 80px;
            margin-top: -80px;
            visibility: hidden;
        }

        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .header .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.3em;
            font-weight: 600;
        }

        .back-link {
            color: white;
            text-decoration: none;
            padding: 8px 18px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            font-size: 0.9em;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-link:hover {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 3px 12px rgba(59, 130, 246, 0.3);
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .sidebar {
            flex: 0 0 280px;
            position: sticky;
            top: 20px;
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            max-height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .sidebar h3 {
            font-size: 1em;
            color: #3b82f6;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            margin-bottom: 8px;
        }

        .sidebar a {
            color: #666;
            text-decoration: none;
            font-size: 0.9em;
            display: block;
            padding: 6px 12px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .sidebar a:hover {
            background: #f0f4ff;
            color: #3b82f6;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
        }

        .sidebar a.active {
            background: #3b82f6;
            color: white;
            font-weight: 500;
        }

        .sidebar .toc-h2 {
            font-weight: 600;
            font-size: 0.95em;
            color: #333;
            margin-top: 8px;
        }

        .sidebar .toc-h3 {
            padding-left: 24px;
            font-size: 0.82em;
            color: #999;
            font-weight: 400;
        }

        .sidebar .toc-h2:hover {
            color: #3b82f6;
        }

        .sidebar .toc-h3:hover {
            color: #3b82f6;
        }

        .content {
            flex: 1;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            min-width: 0;
        }

        @media (max-width: 968px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                position: relative;
                flex: 1 1 auto;
                width: 100%;
                max-height: 400px;
                order: 2;
            }

            .content {
                order: 1;
            }
        }

        .markdown {
            color: #333;
        }

        .markdown h1 {
            font-size: 1.8em;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3b82f6;
            color: #3b82f6;
            font-weight: 600;
        }

        .markdown h2 {
            font-size: 1.5em;
            margin-top: 32px;
            margin-bottom: 16px;
            color: #3b82f6;
            font-weight: 600;
        }

        .markdown h3 {
            font-size: 1.2em;
            margin-top: 24px;
            margin-bottom: 12px;
            color: #1e40af;
            font-weight: 600;
        }

        .markdown h4 {
            font-size: 1.05em;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #555;
            font-weight: 600;
        }

        .markdown p {
            margin-bottom: 14px;
            line-height: 1.7;
            font-size: 0.95em;
            color: #444;
        }

        .markdown ul, .markdown ol {
            margin-bottom: 14px;
            padding-left: 28px;
        }

        .markdown li {
            margin-bottom: 6px;
            line-height: 1.6;
            font-size: 0.95em;
            color: #444;
        }

        .markdown code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.85em;
            color: #c7254e;
        }

        .markdown pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 16px;
            border-radius: 6px;
            overflow-x: auto;
            margin-bottom: 16px;
            font-size: 0.85em;
        }

        .markdown pre code {
            background: none;
            padding: 0;
            color: #f8f8f2;
        }

        .markdown blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 20px;
            margin: 20px 0;
            color: #666;
            font-style: italic;
        }

        .markdown table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .markdown table th,
        .markdown table td {
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
            text-align: left;
            font-size: 0.9em;
        }

        .markdown table th {
            background: #3b82f6;
            color: white;
            font-weight: 600;
        }

        .markdown table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .markdown a {
            color: #3b82f6;
            text-decoration: none;
        }

        .markdown a:hover {
            text-decoration: underline;
        }

        .markdown hr {
            border: none;
            border-top: 2px solid #eee;
            margin: 40px 0;
        }

        @media (max-width: 768px) {
            .content {
                padding: 30px 20px;
            }

            .markdown h1 {
                font-size: 2em;
            }

            .markdown h2 {
                font-size: 1.6em;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>📖 Comprehensive Guide</h1>
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs" class="back-link">← Back to Docs</a>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <h3>📑 Table of Contents</h3>
            <ul>
                <?php
                // Extract headers for table of contents
                $lines = explode("\n", $markdown ?? '');
                $tocItems = [];
                foreach ($lines as $line) {
                    if (preg_match('/^## (.+)$/', $line, $matches)) {
                        $title = trim($matches[1]);
                        $id = strtolower(preg_replace('/[^a-z0-9]+/', '-', $title));
                        echo '<li><a href="#' . htmlspecialchars($id) . '" class="toc-h2">' . htmlspecialchars($title) . '</a></li>';
                    } elseif (preg_match('/^### (.+)$/', $line, $matches)) {
                        $title = trim($matches[1]);
                        $id = strtolower(preg_replace('/[^a-z0-9]+/', '-', $title));
                        echo '<li><a href="#' . htmlspecialchars($id) . '" class="toc-h3">' . htmlspecialchars($title) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>

        <div class="content">
            <div class="markdown">
                <?php
                // Simple markdown to HTML conversion with IDs for anchors
                $html = htmlspecialchars($markdown ?? '');

                // Convert headers with IDs for navigation
                $html = preg_replace_callback('/^#### (.+)$/m', function($matches) {
                    $title = $matches[1];
                    $id = strtolower(preg_replace('/[^a-z0-9]+/', '-', $title));
                    return '<h4 id="' . $id . '">' . $title . '</h4>';
                }, $html);

                $html = preg_replace_callback('/^### (.+)$/m', function($matches) {
                    $title = $matches[1];
                    $id = strtolower(preg_replace('/[^a-z0-9]+/', '-', $title));
                    return '<h3 id="' . $id . '">' . $title . '</h3>';
                }, $html);

                $html = preg_replace_callback('/^## (.+)$/m', function($matches) {
                    $title = $matches[1];
                    $id = strtolower(preg_replace('/[^a-z0-9]+/', '-', $title));
                    return '<h2 id="' . $id . '">' . $title . '</h2>';
                }, $html);

                $html = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $html);

                // Convert bold and italic
                $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);
                $html = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $html);

                // Convert code blocks
                $html = preg_replace('/```(.+?)```/s', '<pre><code>$1</code></pre>', $html);

                // Convert inline code
                $html = preg_replace('/`([^`]+)`/', '<code>$1</code>', $html);

                // Convert lists
                $html = preg_replace('/^- (.+)$/m', '<li>$1</li>', $html);
                $html = preg_replace('/(<li>.*<\/li>\n)+/s', '<ul>$0</ul>', $html);

                // Convert links
                $html = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2">$1</a>', $html);

                // Convert line breaks to paragraphs
                $html = preg_replace('/\n\n/', '</p><p>', $html);
                $html = '<p>' . $html . '</p>';

                // Clean up empty paragraphs
                $html = preg_replace('/<p>\s*<\/p>/', '', $html);
                $html = preg_replace('/<p>(<h[1-6]>)/', '$1', $html);
                $html = preg_replace('/(<\/h[1-6]>)<\/p>/', '$1', $html);
                $html = preg_replace('/<p>(<ul>)/', '$1', $html);
                $html = preg_replace('/(<\/ul>)<\/p>/', '$1', $html);
                $html = preg_replace('/<p>(<pre>)/', '$1', $html);
                $html = preg_replace('/(<\/pre>)<\/p>/', '$1', $html);

                echo $html;
                ?>
            </div>
        </div>
    </div>

    <script>
        // Highlight active section in sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        document.querySelectorAll('.sidebar a').forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === '#' + id) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }, { rootMargin: '-100px 0px -80% 0px' });

            document.querySelectorAll('.markdown h2[id], .markdown h3[id]').forEach(heading => {
                observer.observe(heading);
            });
        });
    </script>
</body>
</html>
