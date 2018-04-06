<?php

namespace TimurFlush\CurrenciesRate\Adapter;

use TimurFlush\CurrenciesRate\Adapter;
use TimurFlush\CurrenciesRate\AdapterInterface;
use TimurFlush\CurrenciesRate\Response;

/**
 * Class Cryptonator
 * @package TimurFlush\CurrenciesRate\Adapter
 * @version 1.0.4
 * @author Timur Flush
 */
class Cryptonator extends Adapter implements AdapterInterface
{
    private $_apiURL = 'https://api.cryptonator.com/api/ticker/%first%-%second%';

    public function getCourse(string $firstPair, string $secondPair)
    {
        $response = new Response();

        $ch = $this->curlInit();

        $url = $this->getFilledMask($this->_apiURL, $firstPair, $secondPair);
        $response->setURL($url);

        $this->setResponse($response);

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_HEADERFUNCTION => [&$response, 'setHeaders'],
        ]);

        $result = curl_exec($ch);
        $this->setResponse($response);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response->setCode((int)$httpCode);
        $this->setResponse($response);

        if ($result === false) {
            var_dump(curl_error($ch));
            return false;
        }

        if ($this->isBotProtection($result)){
            $matches = [];
            preg_match_all('/document.cookie="(.*)"/Ui', $result, $matches, PREG_SET_ORDER);

            if (is_array($matches) && sizeof($matches) > 0){
                $cookieString = '';
                foreach($matches as $cookie){
                    $matches = [];
                    preg_match('/(.*)=(.*);/Ui', $cookie[1], $matches);

                    $cookieString .= $matches[1];
                    $cookieString .= '=';
                    $cookieString .= $matches[2];
                    $cookieString .= '; ';
                }

                $matches = [];
                preg_match('/makeUrl\("(.*)"\);/Ui', $result, $matches);

                $url = $matches[1];

                $matches = [];
                preg_match('/url \+= "(.*)";/Ui', $result, $matches);

                $query = str_replace(['"', '+', ' '], '', $matches[1]);

                if (!isset($matches[1]))
                    return false;

                $response->setURL($url);
                $this->setResponse($response);

                $ch = $this->curlInit();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $url . $query,
                    CURLOPT_COOKIE => $cookieString,
                    CURLOPT_HEADERFUNCTION => [&$response, 'setHeaders']
                ]);
                $result = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($result === false)
                    return false;

                $response->setCode((int)$http_code);
                $this->setResponse($response);
            }
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

    private function curlInit()
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 YaBrowser/18.2.1.174 Yowser/2.5 Safari/537.36',
            //CURLOPT_HEADERFUNCTION => [&$response, 'setHeaders'],
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIEFILE => __DIR__ . '/../cookie.txt',
            CURLOPT_COOKIEJAR => __DIR__ . '/../cookie.txt'
        ]);

        return $ch;
    }


    private function isBotProtection(string $result)
    {
        return preg_match('/location.href/iU', $result);
    }

}