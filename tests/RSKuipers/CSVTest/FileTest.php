<?php

namespace RSKuipers\CSVTest;

use RSKuipers\CSV\File;

/**
 * Class FileTest
 * @package RSKuipers\CSVTest
 */
class FileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Write example CSV data to a temporary file
     * @return string
     */
    protected function getCSVFile()
    {
        $csv = <<< CSV
ID,Name,Age
1,John,19
2,Doe,21
3,Foo,31
4,Bar,52
CSV;
        $tmpFile = tempnam(sys_get_temp_dir(), 'csvtest');
        file_put_contents($tmpFile, $csv);
        return $tmpFile;
    }

    /**
     * Test the fetch method with the File::COLUMN_TITLES mode
     * @test
     */
    public function fetchColumnTitles()
    {
        $file = new File($this->getCSVFile(), 0);
        $file->setMappingMode(File::COLUMN_TITLES);
        $row = $file->fetch();
        $this->assertEquals('John', $row['Name']);
    }

    /**
     * Test the fetch method with the File::INDEX mode
     * @test
     */
    public function fetchIndex()
    {
        $file = new File($this->getCSVFile(), 0);
        $file->setMappingMode(File::INDEX);
        $row = $file->fetch();
        $this->assertEquals('John', $row[1]);
    }

    /**
     * Test the fetch method with the File::CUSTOM mode
     * @test
     */
    public function fetchCustom()
    {
        $file = new File($this->getCSVFile(), 0);
        $file->setMappingMode(File::CUSTOM);
        $file->setMapping(array(
            'ID',
            'First Name',
            'Age',
        ));
        $row = $file->fetch();
        $this->assertEquals('John', $row['First Name']);
    }
}
