<?php

namespace TimurFlush\CurrenciesRate;

/**
 * Class RateManager
 * @package TimurFlush\CurrenciesRate
 * @version 1.0.1
 * @author TimurFlush
 */
class RateManager
{
	/**
	 * @var array
	 */
	private static $_adapterPriority = [];
	
    /**
     * @param string $firstPair
     * @param string $secondPair
     * @return bool|null
     */
    public function getCourse(string $firstPair, string $secondPair)
    {
		if (!sizeof(self::$_adapterPriority))
			self::$_adapterPriority = require __DIR__ . DIRECTORY_SEPARATOR . '/Config/AdapterPriority.php';

        if (!is_array(self::$_adapterPriority))
            return false;

        $rate = null;
        foreach (self::$_adapterPriority as $adapter){
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