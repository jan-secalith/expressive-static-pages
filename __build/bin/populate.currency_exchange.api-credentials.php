<?php

/**
 * Generates database config file for zend-expressive application
 */

$fileDBConfigSource = "./../config/apikeys.local.php";
$fileDBConfigTarget = "./../../application/config/autoload/apikeys.local.php";
$fileYMLConfig = "./../config/credentials.yml";

chdir(__DIR__);

require __DIR__.'/../../application/vendor/autoload.php';

$configFile = file_get_contents($fileDBConfigSource);

$yamlConfig = Spyc::YAMLLoad($fileYMLConfig);

$yamlConfigJsonRates = $yamlConfig['credentials']['modules']['jsonrates'];

$configFile = str_replace('%%jsonrates_apikey_replace%%', $yamlConfigJsonRates['apikey'], $configFile);

file_put_contents($fileDBConfigTarget, $configFile);
