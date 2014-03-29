<?php

namespace RSKuipers\CSV\Formatter;

/**
 * Class Currency
 * @package RSKuipers\CSV\Formatter
 */
class Currency extends Number
{
    /**
     * @var int
     */
    protected $style = \NumberFormatter::CURRENCY;

    /**
     * @param $value
     * @return float
     */
    public function parse($value)
    {
        return $this->formatter->parseCurrency($value, $curr);
    }
}
