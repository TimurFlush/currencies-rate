<?php

namespace TimurFlush\CurrenciesRate;

/**
 * Interface AdapterInterface
 * @package TimurFlush\CurrenciesRate
 * @version 1.0.2
 * @author Timur Flush
 */
interface AdapterInterface
{
    /**
     * Returns the sum of the pair.
     *
     * @param string $firstPair
     * @param string $secondPair
     * @return double|false
     */
    public function getCourse(string $firstPair, string $secondPair);
}
