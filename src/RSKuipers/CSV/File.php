<?php

namespace RSKuipers\CSV;

use RSKuipers\CSV\Formatter\FormatterInterface;
use RSKuipers\CSV\Exception\InvalidMappingException;

/**
 * Class File
 * @package RSKuipers\CSV
 */
class File extends \SplFileObject
{

    /**
     * Use a row in the CSV as the key for the value
     */
    const COLUMN_TITLES = 1;

    /**
     * Use a custom mapping array as the key for the value
     */
    const CUSTOM = 2;

    /**
     * Use the default index based key for the value
     */
    const INDEX = 3;

    /**
     * @var int
     */
    protected $columnTitlesIndex = -1;

    /**
     * @var self::COLUMN_TITLES|self::CUSTOM|self::INDEX
     */
    protected $mappingMode;

    /**
     * @var array
     */
    protected $mapping;

    /**
     * @var int
     */
    protected $position = -1;

    /**
     * @var string
     */
    protected $delimiter = ',';

    /**
     * @var FormatterInterface[]
     */
    protected $formatters = array();

    /**
     * @param string $filename
     * @param int $columnTitlesIndex
     * @param string $open_mode
     * @param bool $use_include_path
     * @param null $context
     */
    public function __construct(
        $filename,
        $columnTitlesIndex = -1,
        $open_mode = 'r',
        $use_include_path = false,
        $context = null
    ) {
        $this->columnTitlesIndex = $columnTitlesIndex;
        if (is_null($context)) {
            parent::__construct($filename, $open_mode, $use_include_path);
        } else {
            parent::__construct($filename, $open_mode, $use_include_path, $context);
        }
    }

    /**
     * @return array
     * @throws InvalidMappingException
     */
    public function fetch()
    {
        while ($row = $this->fgetcsv($this->delimiter)) {
            $this->position++;
            if (!count($row) || (count($row) === 1 && is_null($row[0]))) {
                continue;
            }
            if ($this->position < $this->columnTitlesIndex) {
                continue;
            }
            if ($this->mappingMode == self::COLUMN_TITLES) {
                if ($this->position == $this->columnTitlesIndex) {
                    $this->mapping = array_filter($row);
                    continue;
                }
                $row = array_combine($this->mapping, $row);
            } elseif ($this->mappingMode == self::CUSTOM) {
                if ($this->position == $this->columnTitlesIndex) {
                    continue;
                }
                if (!is_array($this->mapping)) {
                    throw new InvalidMappingException('Mapping is set to custom but no mapping was found.');
                }
                $row = array_combine($this->mapping, $row);
            } else {
                if ($this->position == $this->columnTitlesIndex) {
                    continue;
                }
            }
            foreach ($this->formatters as $column => $formatter) {
                $row[$column] = $formatter->parse($row[$column]);
            }
            return $row;
        }
    }

    /**
     * @param $column
     * @param FormatterInterface $formatter
     */
    public function setFormatter($column, FormatterInterface $formatter)
    {
        $this->formatters[$column] = $formatter;
    }

    /**
     * @param int $columnTitlesIndex
     */
    public function setColumnTitlesIndex($columnTitlesIndex)
    {
        $this->columnTitlesIndex = $columnTitlesIndex;
    }

    /**
     * @return int
     */
    public function getColumnTitlesIndex()
    {
        return $this->columnTitlesIndex;
    }

    /**
     * @param array $mapping
     */
    public function setMapping($mapping)
    {
        $this->mapping = $mapping;
    }

    /**
     * @return array
     */
    public function getMapping()
    {

        return $this->mapping;
    }

    /**
     * @param int $mappingMode
     */
    public function setMappingMode($mappingMode)
    {
        $this->mappingMode = $mappingMode;
    }

    /**
     * @return int
     */
    public function getMappingMode()
    {
        return $this->mappingMode;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }
}
