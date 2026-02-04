<?php
echo "Before config include<br>\n";
flush();

require_once __DIR__ . '/includes/config.php';

echo "After config include<br>\n";
echo "SO_DIST_PATH: " . SO_DIST_PATH . "<br>\n";
echo "SO_DEMO_BASE: " . SO_DEMO_BASE . "<br>\n";
echo "Config loaded successfully!<br>\n";
