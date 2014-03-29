<?php

namespace RSKuipers\CSVTest;

use RSKuipers\CSV\File;
use RSKuipers\CSV\Formatter\FormatterInterface;

/**
 * Class FormatterTest
 * @package RSKuipers\CSVTest
 */
class FormatterTest extends \PHPUnit_Framework_TestCase
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
4,Book,€1
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
        /** @var FormatterInterface $fooFormatter */
        $fooFormatter = $this->getMock('RSKuipers\CSV\Formatter\FormatterInterface', array('parse'));
        $fooFormatter->expects($this->atLeastOnce())
            ->method('parse')
            ->will($this->returnValue('Foo'));
        $csv = new File($this->getCSVFile(), 0);
        $csv->setMappingMode(File::COLUMN_TITLES);
        $csv->setFormatter('Name', $fooFormatter);
        $row = $csv->fetch();
        $this->assertEquals('Foo', $row['Name']);
    }
}
