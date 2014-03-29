<?php

namespace RSKuipers\CSV\Formatter;

/**
 * Class Number
 * @package RSKuipers\CSV\Formatter
 */
abstract class Number implements FormatterInterface
{
    /**
     * @var int
     */
    protected $style = \NumberFormatter::DECIMAL;

    /**
     * @var null|string
     */
    protected $locale;

    /**
     * @var \NumberFormatter
     */
    protected $formatter;

    /**
     * @param null $locale
     */
    public function __construct($locale = null)
    {
        $this->locale = is_null($locale) ? locale_get_default() : $locale;
        $this->formatter = new \NumberFormatter($this->locale, $this->style);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function parse($value)
    {
        return $this->formatter->parse($value);
    }
}
