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

$configfile = __DIR__ . '/../../config.yml';
if (!file_exists($configfile)) {
    throw new \Exception('Could not load config file - create a config.yml file');
} else {
    $yaml = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($configfile));
    if (array_key_exists('apikey', $yaml) && array_key_exists('apisecret', $yaml)) {
        define('JWTEST_APIKEY', $yaml['apikey']);
        define('JWTEST_APISECRET', $yaml['apisecret']);
    } else {
        throw new \Exception('Could not load config file - apikey and apisecret needs to be in the config file');
    }
}