<?php

namespace TimurFlush\CurrenciesRate;

/**
 * Class RateManager
 * @package TimurFlush\CurrenciesRate
 * @version 1.0.2
 * @author TimurFlush
 */
class RateManager
{
	/**
	 * @var array
	 */
	private static $_adapterPriority = [];

    /**
     * @var array
     */
	private $_response = [];

	public function getResponseStack() : array
    {
        return $this->_response;
    }

    public function pushResponseStack(Response $response) : void
    {
        $this->_response[] = $response;
    }

    private function flushResponseStack() : void
    {
        $this->_response = [];
    }

    /**
     * @param string $firstPair
     * @param string $secondPair
     * @return bool|null
     */
    public function getCourse(string $firstPair, string $secondPair)
    {
        $this->flushResponseStack();

		if (!sizeof(self::$_adapterPriority))
			self::$_adapterPriority = require __DIR__ . DIRECTORY_SEPARATOR . '/Config/AdapterPriority.php';

        if (!is_array(self::$_adapterPriority))
            return false;

        $rate = null;
        foreach (self::$_adapterPriority as $adapter){
            $adapter = new $adapter;
            $get = $adapter->getCourse($firstPair, $secondPair);
            $this->pushResponseStack($adapter->getResponse());

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