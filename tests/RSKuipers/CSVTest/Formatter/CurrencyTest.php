<?php

namespace RSKuipers\CSVTest\Formatter;

use RSKuipers\CSV\File;
use RSKuipers\CSV\Formatter\Currency;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Write example CSV data to a temporary file
     * @return string
     */
    protected function getCSVFile()
    {
        $csv = <<< CSV
ID,Name,Price
1,Lighter,"€ 15,95"
2,Chair,"€ 17"
3,Table,"€ 19,91"
4,Book,"€ 1"
CSV;
        $tmpFile = tempnam(sys_get_temp_dir(), 'csvtest');
        file_put_contents($tmpFile, $csv);
        return $tmpFile;
    }

    /**
     * @test
     */
    public function itShouldParseColumnAsFloat()
    {
        $priceFormatter = new Currency('nl_NL');
        $csv = new File($this->getCSVFile(), 0);
        $csv->setMappingMode(File::COLUMN_TITLES);
        $csv->setFormatter('Price', $priceFormatter);
        $row = $csv->fetch();
        $this->assertInternalType('float', $row['Price']);
        $this->assertEquals(15.95, $row['Price']);
        $row = $csv->fetch();
        $this->assertEquals(17, $row['Price']);
        $row = $csv->fetch();
        $this->assertEquals(19.91, $row['Price']);
        $row = $csv->fetch();
        $this->assertEquals(1, $row['Price']);
    }
}
