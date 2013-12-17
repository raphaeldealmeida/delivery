<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/Delivery/src/Delivery/Entity"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'delivery',
                )
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

return ConsoleRunner::createHelperSet($entityManager);