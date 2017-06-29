<?php


include_once __DIR__.'/../vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("tinhead\\test\\tests\serialization\\", __DIR__ . "/tests/serialization", true);
$classLoader->addPsr4("tinhead\\test\\tests\\controller\\", __DIR__ . "/tests/controller", true);

$classLoader->addPsr4("tinhead\\test\\testutils\\", __DIR__ . "/testutils", true);
$classLoader->register();

