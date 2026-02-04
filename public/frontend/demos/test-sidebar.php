<?php
echo "Testing sidebar load...<br>\n";
flush();

require_once __DIR__ . '/includes/config.php';
echo "Config OK<br>\n";
flush();

require_once __DIR__ . '/includes/sidebar.php';
echo "Sidebar OK<br>\n";
flush();

echo "All includes loaded successfully!";
