<?php

namespace TimurFlush\CurrenciesRate;

/**
 * Class Adapter
 * @package TimurFlush\CurrenciesRate
 * @version 1.0.0
 * @author Timur Flush
 */
abstract class Adapter
{
    /**
     * Returns the filled mask.
     *
     * @param $mask
     * @param $firstPair
     * @param $secondPair
     * @return mixed
     */
    public function getFilledMask($mask, $firstPair, $secondPair)
    {
        return str_replace(['%first%', '%second%'], [$firstPair, $secondPair], $mask);
    }
}