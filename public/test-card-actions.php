<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/helpers.php';

use Core\UiEngine\UiEngine;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Card Actions</title>
    <link rel="stylesheet" href="/frontend/dist/css/sixorbit-full.25c08728.css">
</head>
<body style="padding: 20px;">

<h1>Test Card with All Actions</h1>

<?php
$testCard = UiEngine::card()
    ->id('test-card-1')
    ->header('Test Card Header')
    ->body('Test card body content')
    ->footer('Test card footer')
    ->collapsible()
    ->refreshable()
    ->maximizable()
    ->closeable(true, 'Close this card?');

echo $testCard->render();
?>

<hr>

<h2>Raw HTML Output:</h2>
<pre><?php echo htmlspecialchars($testCard->render()); ?></pre>

</body>
</html>
