<?php

namespace Just2trade\DoctrineExtensions\Tests;

use PHPUnit\Framework\TestCase;

class DoctrineExtensionTestCase extends TestCase
{
    public $entityManager = null;

    protected function setUp(): void
    {
        if (!class_exists('\Doctrine\ORM\Configuration')) {
            $this->markTestSkipped('Doctrine is not available');
        }

        $cache = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCache($cache);
        $config->setQueryCache($cache);
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('Just2trade\DoctrineExtensions\Tests\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__ . '/Entities'));
        $config->addEntityNamespace('Test', 'Just2trade\DoctrineExtensions\Tests\Entities');

        $config->setCustomStringFunctions([
            'every'            => 'Just2trade\DoctrineExtensions\Doctrine\Query\Every',
            'right'            => 'Just2trade\DoctrineExtensions\Doctrine\Query\Right',
            'inarray'          => 'Just2trade\DoctrineExtensions\Doctrine\Query\InArray',
        ]);

        $config->setCustomDatetimeFunctions([
            'to_char'          => 'Just2trade\DoctrineExtensions\Doctrine\Query\ToChar',
            'date_trunc'       => 'Just2trade\DoctrineExtensions\Doctrine\Query\DateTrunc',
        ]);

        $this->entityManager = \Doctrine\ORM\EntityManager::create(
            ['driver' => 'pdo_sqlite', 'memory' => true],
            $config
        );
    }
}