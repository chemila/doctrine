<?php
/**
 * Welcome to Doctrine 2.
 * 
 * This is the index file of the sandbox. The first section of this file
 * demonstrates the bootstrapping and configuration procedure of Doctrine 2.
 * Below that section you can place your test code and experiment.
 */

namespace Sandbox;

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\DBAL\Logging\EchoSQLLogger,
    Doctrine\Common\Cache\ArrayCache,
    Entities\User, Entities\Address, Entities\Leader,
    Doctrine\Common\Util\Debug;

require_once '../../lib/vendor/doctrine-common/lib/Doctrine/Common/ClassLoader.php';

// Set up class loading. You could use different autoloaders, provided by your favorite framework,
// if you want to.
$classLoader = new ClassLoader('Doctrine\ORM', realpath(__DIR__ . '/../../lib'));
$classLoader->register();
$classLoader = new ClassLoader('Doctrine\DBAL', realpath(__DIR__ . '/../../lib/vendor/doctrine-dbal/lib'));
$classLoader->register();
$classLoader = new ClassLoader('Doctrine\Common', realpath(__DIR__ . '/../../lib/vendor/doctrine-common/lib'));
$classLoader->register();
$classLoader = new ClassLoader('Symfony', realpath(__DIR__ . '/../../lib/vendor'));
$classLoader->register();
$classLoader = new ClassLoader('Entities', __DIR__);
$classLoader->register();
$classLoader = new ClassLoader('Proxies', __DIR__);
$classLoader->register();

// Set up caches
$config = new Configuration;
$cache = new ArrayCache;
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver(array(__DIR__."/Entities"));
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);

// Proxy configuration
$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$config->setAutoGenerateProxyClasses(true);

// LOGGIN SQL
$logger = new EchoSQLLogger;
$config->setSQLLogger($logger);

// Database connection information
$connectionOptions = array(
    'driver' => 'pdo_mysql',
    'path' => 'database.mysql',
    'dbname' => 'test_doctrine',
    'user' => 'root',
    'password' => 'root',
);

// Create EntityManager
$em = EntityManager::create($connectionOptions, $config);

// PUT YOUR TEST CODE BELOW
/**
$user = new User;
$address = new Address;
$address->setStreet('beijing');
$user->setName('Chemila');
$leader->setName('Ethan');
$leader->setWhat('a leader');

$em->persist($user);
$em->persist($leader);
$em->flush();
**/

$q = $em->createQuery();
$q->setDql('SELECT l,UPPER(l.name) uname FROM Entities\User l WHERE l.name=:name');
$q->setParameter('name', 'ethan');
$r = $q->getResult();

echo '<br>';
Debug::dump($r);
