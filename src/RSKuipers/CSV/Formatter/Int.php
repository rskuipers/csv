<?php

namespace RSKuipers\CSV\Formatter;

/**
 * Class Int
 * @package RSKuipers\CSV\Formatter
 */
class Int extends Number
{
    /**
     * @param $value
     * @return int
     */
    public function parse($value)
    {
        return intval(parent::parse($value));
    }
}
