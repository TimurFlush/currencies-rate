<?php

namespace TimurFlush\CurrenciesRate;

/**
 * Class Adapter
 * @package TimurFlush\CurrenciesRate
 * @version 1.0.1
 * @author Timur Flush
 */
abstract class Adapter
{
    /**
     * @var Response
     */
    protected $_response;

    /**
     * Returns the filled mask.
     *
     * @param $mask
     * @param $firstPair
     * @param $secondPair
     * @return mixed
     */
    public function getFilledMask($mask, $firstPair, $secondPair) : string
    {
        return str_replace(['%first%', '%second%'], [$firstPair, $secondPair], $mask);
    }

    /**
     *
     * @param Response $response
     */
    protected function setResponse(Response $response)
    {
        $this->_response = $response;
    }

    /**
     * Returns the last response.
     *
     * @return Response
     */
    public function getResponse() : ?Response
    {
        return $this->_response;
    }
}