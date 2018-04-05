<?php

namespace TimurFlush\CurrenciesRate;

/**
 * Class Response
 * @package TimurFlush\CurrenciesRate
 * @author Timur Flush
 * @version 1.0.2
 */
class Response
{
    private $_url = '';

    private $_body = '';

    private $_code = 0;

    private $_headers = [];

    public function setHeaders($curl, $headerLine) : int
    {
        $length = strlen($headerLine);
        $headerLine = explode(':', $headerLine, 2);

        if (count($headerLine) !== 2) // ignore invalid headers
            return $length;

        $this->_headers[trim($headerLine[0])] = trim($headerLine[1]);
        $this->_headers[strtolower(trim($headerLine[0]))] = trim($headerLine[1]);

        return $length;

    }

    public function getHeaders() : array
    {
        return $this->_headers;
    }

    public function setURL(string $url) : void
    {
        $this->_url = $url;
    }

    public function getURL() : string
    {
        return $this->_url;
    }

    public function setBody(string $body) : void
    {
        $this->_body = $body;
    }

    public function getBody() : string
    {
        return $this->_body;
    }

    public function setCode(int $code) : void
    {
        $this->_code = $code;
    }

    public function getCode() : int
    {
        return $this->_code;
    }

}