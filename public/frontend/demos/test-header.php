<?php
echo "Before includes<br>\n";
flush();

require_once __DIR__ . '/includes/config.php';
echo "Config loaded<br>\n";
flush();

require_once __DIR__ . '/includes/header.php';
echo "Header loaded<br>\n";
flush();
