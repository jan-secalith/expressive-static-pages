<?php
/**
 * Script for clearing the configuration skeleton.
 *
 * Can also be invoked as `composer clear-config-skeleton`.
 *
 * @see       https://github.com/zendframework/zend-expressive-skeleton for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);


chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$config = include __DIR__ . '/../config/config.php';
//$config = new PhpFileProvider(realpath(__DIR__) . '/../config/config.php');
var_dump($config);
$aggregator = new ArrayProvider([
    $config
]);

var_dump($aggregator);
//var_dump(new PhpFileProvider(realpath(__DIR__) . '/../config/config.php'));
//
//var_dump(__DIR__ .  '/../config/config.php');


if (! isset($config['config_cache_path'])) {
    echo "No configuration skeleton path found" . PHP_EOL;
    exit(0);
}

if (! file_exists($config['config_cache_path'])) {
    printf(
        "Configured config skeleton file '%s' not found%s",
        $config['config_cache_path'],
        PHP_EOL
    );
    exit(0);
}

if (false === unlink($config['config_cache_path'])) {
    printf(
        "Error removing config skeleton file '%s'%s",
        $config['config_cache_path'],
        PHP_EOL
    );
    exit(1);
}

printf(
    "Removed configured config skeleton file '%s'%s",
    $config['config_cache_path'],
    PHP_EOL
);
exit(0);
