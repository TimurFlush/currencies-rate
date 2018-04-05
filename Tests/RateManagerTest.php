<?php

namespace TimurFlush\CurrenciesRate\Tests;

use PHPUnit\Framework\TestCase;
use TimurFlush\CurrenciesRate\RateManager;

class RateManagerTest extends TestCase
{
    /**
     * @var \TimurFlush\CurrenciesRate\RateManager
     */
    private $_rateManager;

    public function setUp()
    {
        $this->_rateManager = new RateManager();
    }

    public function testGetCourse()
    {
        if ($this->_rateManager->getCourse('USD', 'RUB')){
            $this->assertTrue(true);
            return;
        }

        $this->markTestSkipped(
            'API is not available. Information: '
            . PHP_EOL
            . print_r($this->_rateManager->getResponseStack(), true)
        );
    }

    public function tearDown()
    {
        unset($this->_rateManager);
    }
}