<?php

namespace TimurFlush\CurrenciesRate\Adapter;

use TimurFlush\CurrenciesRate\Adapter;
use TimurFlush\CurrenciesRate\AdapterInterface;
use TimurFlush\CurrenciesRate\Response;

/**
 * Class Cryptonator
 * @package TimurFlush\CurrenciesRate\Adapter
 * @version 1.0.3
 * @author Timur Flush
 */
class Cryptonator extends Adapter implements AdapterInterface
{
    private $_apiURL = 'https://api.cryptonator.com/api/ticker/%first%-%second%';

    public function getCourse(string $firstPair, string $secondPair)
    {
        $response = new Response();

        $ch = curl_init();

        $url = $this->getFilledMask($this->_apiURL, $firstPair, $secondPair);
        $response->setURL($url);

        $this->setResponse($response);

        curl_setopt_array($ch, [
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 YaBrowser/18.2.1.174 Yowser/2.5 Safari/537.36',
            CURLOPT_HEADERFUNCTION => [&$response, 'setHeaders'],
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $this->setResponse($response);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response->setCode((int)$httpCode);

        $this->setResponse($response);

        if ($result === false) {
            var_dump(curl_error($ch));
            return false;
        }

        $response->setBody($result);

        $this->setResponse($response);

        $ticker = @json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE)
            return false;

        if (!isset($ticker['ticker']['price']))
            return false;

        return (double)$ticker['ticker']['price'];
    }
}