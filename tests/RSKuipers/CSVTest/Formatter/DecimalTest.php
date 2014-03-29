<?php

namespace RSKuipers\CSVTest\Formatter;

use RSKuipers\CSV\File;;
use RSKuipers\CSV\Formatter\Decimal;

class DecimalTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Write example CSV data to a temporary file
     * @return string
     */
    protected function getCSVFile()
    {
        $csv = <<< CSV
ID,Name,Rating,Views
1,Lighter,"5,6","3.230"
2,Chair,"6","2.093.230"
3,Table,"8,0","530"
4,Book,"9,2","76.126"
CSV;
        $tmpFile = tempnam(sys_get_temp_dir(), 'csvtest');
        file_put_contents($tmpFile, $csv);
        return $tmpFile;
    }

    /**
     * @test
     */
    public function itShouldParseColumnAsDecimal()
    {
        $decimalFormatter = new Decimal('nl_NL');
        $csv = new File($this->getCSVFile(), 0);
        $csv->setMappingMode(File::COLUMN_TITLES);
        $csv->setFormatter('Rating', $decimalFormatter);
        $csv->setFormatter('Views', $decimalFormatter);
        $row = $csv->fetch();
        $this->assertInternalType('float', $row['Rating']);
        $this->assertEquals(5.6, $row['Rating']);
        $this->assertEquals(3230, $row['Views']);
        $row = $csv->fetch();
        $this->assertEquals(2093230, $row['Views']);
    }
}
