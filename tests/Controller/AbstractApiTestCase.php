<?php

namespace App\Tests\Controller;

use App\Tests\AbstractTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

abstract class AbstractApiTestCase extends AbstractTestCase
{
    /**
     * @var KernelBrowser
     */
    protected static $client;

    public static function setUpBeforeClass(): void
    {
        self::ensureKernelShutdown();

        self::$client = self::createClient();
    }
}