<?php
require __DIR__ . '/../../vendor/mustache/mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();
$m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../views'),
    'cache' => __DIR__ .'/../../tmp/cache/mustache',
));
echo $m->render('admin', array('world' => 'World')); // "Hello, World!"