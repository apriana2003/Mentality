<?php
/**
 * @var CodeIgniter\Debug\ExceptionHandler $handler
 * @var Throwable                          $exception
 */
$statusCode = isset($statusCode) ? $statusCode : 500;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $statusCode ?> - Error</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 800px; margin: 0 auto; }
        h1 { color: #e74c3c; }
        p { color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Whoops! <?= $statusCode ?></h1>
        <p><?= isset($exception) ? esc($exception->getMessage()) : 'An error occurred.' ?></p>
    </div>
</body>
</html>