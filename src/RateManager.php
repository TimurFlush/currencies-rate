<?php

namespace TimurFlush\CurrenciesRate;

/**
 * Class RateManager
 * @package TimurFlush\CurrenciesRate
 * @version 1.0.0
 * @author TimurFlush
 */
class RateManager
{
    /**
     * @param string $firstPair
     * @param string $secondPair
     * @return bool|null
     */
    public function getCourse(string $firstPair, string $secondPair)
    {
        $adapterPriority = require_once __DIR__ . DIRECTORY_SEPARATOR . '/Config/AdapterPriority.php';

        if (!is_array($adapterPriority))
            return false;

        $rate = null;
        foreach ($adapterPriority as $adapter){
            $adapter = new $adapter;
            $get = $adapter->getCourse($firstPair, $secondPair);

            if ($get === false OR $get <= 0)
                continue;

            $rate = $get;
            break;
        }

        if (!$rate)
            return false;

        return $rate;
    }
}