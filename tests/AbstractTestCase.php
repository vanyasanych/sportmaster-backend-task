<?php

namespace App\Tests;


use App\Entity\Cart;
use App\Entity\Inventory;
use App\Entity\Product;
use App\Entity\ProductGroup;
use App\Entity\Store;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractTestCase extends WebTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected static $entityManager;

    /**
     * @var string|null
     */
    private $defaultTimezone = null;

    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        self::ensureKernelShutdown();

        self::tearDownAfterClass();
    }

    /**
     * @throws Exception
     */
    public static function tearDownAfterClass(): void
    {
        $testCase = new static();

        $testCase->truncateEntities($testCase->getUsedEntities());

        if (self::$entityManager !== null) {
            $testCase->closeEntityManager();
        }
    }

    protected function setUp(): void
    {
        static::ensureKernelShutdown();

        $this->setDefaultTimezone('UTC');
    }

    protected function tearDown(): void
    {
        $this->closeEntityManager();

        $this->restoreDefaultTimezone();
    }

    /**
     * @param string $defaultTimezone
     */
    protected function setDefaultTimezone(string $defaultTimezone): void
    {
        // Make sure this method can not be called twice before calling
        // also restoreDefaultTimezone()
        if (null === $this->defaultTimezone) {
            $this->defaultTimezone = date_default_timezone_get();
            date_default_timezone_set($defaultTimezone);
        }
    }

    protected function restoreDefaultTimezone(): void
    {
        if (null !== $this->defaultTimezone) {
            date_default_timezone_set($this->defaultTimezone);
            $this->defaultTimezone = null;
        }
    }

    /**
     * @param array $entities
     *
     * @throws Exception
     */
    protected function truncateEntities(array $entities): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();

        foreach ($entities as $entity) {
            $table = $this->getEntityManager()->getClassMetadata($entity)->getTableName();

            $queryTruncate = $databasePlatform->getTruncateTableSQL($table, true);
            $connection->executeStatement($queryTruncate);
        }

        $this->restartSequences($entities);
    }

    /**
     * @param array $entities
     *
     * @throws Exception
     */
    protected function restartSequences(array $entities)
    {
        $connection = $this->getEntityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();

        foreach ($entities as $entity) {
            $table = $this->getEntityManager()->getClassMetadata($entity)->getTableName();
            $identifiers = $this->getEntityManager()->getClassMetadata($entity)->getIdentifierColumnNames();
            foreach ($identifiers as $identifier) {
                $sequenceName = $databasePlatform->getIdentitySequenceName($table, $identifier);
                $sequence = new Sequence($sequenceName);

                $querySequence = 'ALTER SEQUENCE IF EXISTS ' . $sequence->getQuotedName($databasePlatform) .
                    ' INCREMENT BY ' . $sequence->getAllocationSize() .
                    ' RESTART WITH 1'
                ;

                $connection->executeStatement($querySequence);
            }
        }
    }

    /**
     * @return ContainerInterface
     */
    protected static function getContainer(): ContainerInterface
    {
        if (self::$container === null) {
            self::bootKernel();
        }

        return self::$container;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        if (self::$entityManager === null) {
            self::$entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        }

        return self::$entityManager;
    }

    protected function closeEntityManager(): void
    {
        $this->getEntityManager()->close();
        self::$entityManager = null;
    }

    /**
     * @return array
     */
    abstract protected function getUsedEntities(): array;


}