<?php

namespace TimurFlush\CurrenciesRate\Tests;

use PHPUnit\Framework\TestCase;
use TimurFlush\CurrenciesRate\Response;

class ResponseTest extends TestCase
{
    /**
     * @var Response
     */
    private $_response;

    private $test = [
        'header' => 'Connection: close',
        'body' => __CLASS__,
        'code' => 228,
        'url' => 'https://pornhub.com'
    ];

    public function __construct()
    {
        $this->_response = new Response();
        $this->_response->setHeaders(null, $this->test['header']);
        $this->_response->setBody($this->test['body']);
        $this->_response->setCode($this->test['code']);
        $this->_response->setURL($this->test['url']);

        parent::__construct();
    }

    public function testSetHeaders()
    {
        $sh = $this->_response->setHeaders(null, $this->test['header']);
        $this->assertTrue(strlen($this->test['header']) === $sh);
    }

    public function testGetHeaders()
    {
        $exp = explode(':', $this->test['header'], 2);
        $this->assertTrue(
            json_encode($this->_response->getHeaders()) === json_encode([trim($exp[0]) => trim($exp[1]), trim(strtolower($exp[0])) => trim($exp[1])])
        );
    }

    public function testGetBody()
    {
        $this->assertTrue($this->_response->getBody() === $this->test['body']);
    }

    public function testGetCode()
    {
        $this->assertEquals($this->_response->getCode(), $this->test['code']);
    }

    public function testGetURL()
    {
        $this->assertEquals($this->_response->getURL(), $this->test['url']);
    }

    public function __destruct()
    {
        unset($this->_response);
    }
}