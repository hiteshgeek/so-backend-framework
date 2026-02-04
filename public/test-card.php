<?php
require_once __DIR__ . '/../bootstrap/app.php';

use Core\UiEngine\Elements\Display\Card;

try {
    $card = Card::make();
    echo "Card class loaded successfully!\n";
    echo "Card type: " . get_class($card) . "\n";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
