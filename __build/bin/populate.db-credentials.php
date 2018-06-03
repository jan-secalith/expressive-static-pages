<?php

/**
 * Generates database config file for zend-expressive application
 */


chdir(__DIR__);

require __DIR__.'/../../expressive/vendor/autoload.php';

// Source for the specimen file
$fileDBConfigSource = "./../config/zend-db.local.php";
// Path where to copy processed file
$fileDBConfigTarget = "./../../expressive/config/autoload/zend-db.local.php";
// credentials source
$fileYMLConfig = "./../config/credentials.yml";

$configFile = file_get_contents($fileDBConfigSource);

$yamlConfig = Spyc::YAMLLoad($fileYMLConfig);

$yamlConfigLocalAdapter = $yamlConfig['credentials']['database']['local_adapter'];

// replace tokens with data provided from the file
$configFile = str_replace('%%DB_SCHEMA%%', $yamlConfigLocalAdapter['dbname'], $configFile);
$configFile = str_replace('%%DB_HOST%%', $yamlConfigLocalAdapter['dbhost'], $configFile);
$configFile = str_replace('%%DB_USERNAME%%', $yamlConfigLocalAdapter['dbuser'], $configFile);
$configFile = str_replace('%%DB_PASSWORD%%', $yamlConfigLocalAdapter['dbpassword'], $configFile);

file_put_contents($fileDBConfigTarget, $configFile);
