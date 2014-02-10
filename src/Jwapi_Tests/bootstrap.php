<?php
$dirs = array(
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/../../autoload.php'
);

$filefound = false;
foreach($dirs as $dir) {
    if (file_exists($dir)) {
        $filefound = true;
        require $dir;
        break;
    }
}

if (! $filefound) {
    throw new \Exception('Could not load dependencies');
}