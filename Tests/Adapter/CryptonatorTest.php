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
        if ($this->_adapter->getCourse('USD', 'RUB')){
            $this->assertTrue(true);
            return;
        }

        $this->markTestSkipped(
            'API is not available. Information: '
            . PHP_EOL
            . print_r($this->_adapter->getResponse(), true)
        );
    }

    public function tearDown()
    {
        unset($this->_adapter);
    }
}