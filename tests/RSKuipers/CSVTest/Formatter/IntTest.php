<?php

namespace RSKuipers\CSVTest\Formatter;

use RSKuipers\CSV\File;
use RSKuipers\CSV\Formatter\Int;

/**
 * Class IntTest
 * @package RSKuipers\CSVTest\Formatter
 */
class IntTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Write example CSV data to a temporary file
     * @return string
     */
    protected function getCSVFile()
    {
        $csv = <<< CSV
ID,Name,Stock
1,Lighter,12
2,Chair,"15.000"
3,Table,"14,4"
4,Book,7
CSV;
        $tmpFile = tempnam(sys_get_temp_dir(), 'csvtest');
        file_put_contents($tmpFile, $csv);
        return $tmpFile;
    }

    /**
     * @test
     */
    public function itShouldParseColumnAsInt()
    {
        $intFormatter = new Int('nl_NL');
        $csv = new File($this->getCSVFile(), 0);
        $csv->setMappingMode(File::COLUMN_TITLES);
        $csv->setFormatter('Stock', $intFormatter);
        $row = $csv->fetch();
        $this->assertInternalType('int', $row['Stock']);
        $this->assertEquals(12, $row['Stock']);
        $row = $csv->fetch();
        $this->assertEquals(15000, $row['Stock']);
        $row = $csv->fetch();
        $this->assertEquals(14, $row['Stock']);
    }
}
