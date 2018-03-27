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
        $this->assertNotFalse($this->_rateManager->getCourse('USD', 'RUB'), 'Could not get the course. API is not available.');
    }

    public function tearDown()
    {
        unset($this->_rateManager);
    }
}