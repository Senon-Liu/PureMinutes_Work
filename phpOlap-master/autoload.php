<?php

require_once __DIR__.'/vendor/Symfony/Component/ClassLoader/ClassLoader.php';

use Symfony\Component\ClassLoader\ClassLoader;

$loader = new ClassLoader();

// $loader->registerNamespaces(array(
// 	'phpOlap\\Tests' => __DIR__.'/tests',
// 	'phpOlap' => __DIR__.'/src',
// 	'Symfony' => __DIR__.'/vendor',
// ));

$loader->register();