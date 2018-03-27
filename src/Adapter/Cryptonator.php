<?php

namespace TimurFlush\CurrenciesRate\Adapter;

use TimurFlush\CurrenciesRate\Adapter;
use TimurFlush\CurrenciesRate\AdapterInterface;

/**
 * Class Cryptonator
 * @package TimurFlush\CurrenciesRate\Adapter
 * @version 1.0.0
 * @author Timur Flush
 */
class Cryptonator extends Adapter implements AdapterInterface
{
    private $_apiURL = 'https://api.cryptonator.com/api/ticker/%first%-%second%';

    public function getCourse(string $firstPair, string $secondPair)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $this->getFilledMask($this->_apiURL, $firstPair, $secondPair)
        ]);

        $result = curl_exec($ch);

        if ($result === false)
            return false;

        $ticker = @json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE)
            return false;

        if (!isset($ticker['ticker']['price']))
            return false;

        return (double)$ticker['ticker']['price'];
    }
}