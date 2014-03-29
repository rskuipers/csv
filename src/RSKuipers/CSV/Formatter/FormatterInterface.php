<?php

namespace RSKuipers\CSV\Formatter;

/**
 * Interface FormatterInterface
 * @package RSKuipers\CSV\Formatter
 */
interface FormatterInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function parse($value);
}
