<?php

require __DIR__ . '/../vendor/autoload.php';


function config($key) {
    $config = require __DIR__ . '/../src/searchable.php';

    $key = explode('.', $key)[1];

    return $config[$key];
}
