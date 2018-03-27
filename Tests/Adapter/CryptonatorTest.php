<?php

namespace TimurFlush\CurrenciesRate\Tests\Adapter;

use PHPUnit\Framework\TestCase;
use TimurFlush\CurrenciesRate\Adapter\Cryptonator;

class CryptonatorTest extends TestCase
{
    /**
     * @var \TimurFlush\CurrenciesRate\RateManager
     */
    private $_adapter;

    public function setUp()
    {
        $this->_adapter = new Cryptonator();
    }

    public function testGetCourse()
    {
        $this->assertNotFalse($this->_adapter->getCourse('USD', 'RUB'), 'Could not get the course. API is not available.');
    }

    public function tearDown()
    {
        unset($this->_adapter);
    }
}