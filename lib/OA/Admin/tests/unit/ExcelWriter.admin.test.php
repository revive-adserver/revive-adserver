<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Admin/ExcelWriter.php';

/**
 * A class for testing the OA_Admin_ExcelWriter class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 */
class Test_OA_Admin_ExcelWriter extends UnitTestCase
{
    private $decimalFormatting;

    public function setUp()
    {
        $this->decimalFormatting = $GLOBALS['excel_decimal_formatting'] ?? null;
        $GLOBALS['excel_decimal_formatting'] = '#,##0.00';
    }

    public function tearDown()
    {
        if ($this->decimalFormatting === null) {
            unset($GLOBALS['excel_decimal_formatting']);
        } else {
            $GLOBALS['excel_decimal_formatting'] = $this->decimalFormatting;
        }
    }

    public function testUntrustedTextIsWrittenLiterally()
    {
        $writer = new OA_Admin_ExcelWriter();
        $workbook = new Spreadsheet_Excel_Writer();
        $workbook->setVersion(8);
        $writer->_setExcelWriter($workbook);
        $writer->createReportWorksheet('Report', '=1+1', ['@SUM(1,2)' => '=2+2'], ['=3+3']);
        $values = [
            '=CONCATENATE("Payout changed"," example.invalid")',
            '@SUM(1,2)',
            '=SUM({column0}{row})',
            'https://example.invalid/',
            'mailto:user@example.invalid',
            'internal:Sheet2!A1',
            'external:other.xls',
            '00123',
            '+1+1',
            '-1+1',
            "\t=1+1",
            '普通の名前',
        ];
        $writer->createReportSection('Report', '=4+4', ['=5+5' => 'text'], array_map(static fn($value) => [$value], $values), 25, [1 => array_fill(0, count($values), false)]);
        [$types, $cells] = $this->readWorksheetRecords($writer->_worksheet['Report']);
        $this->assertFalse(in_array(0x0006, $types), 'No implicit formula records');
        $this->assertFalse(in_array(0x01B8, $types), 'No implicit hyperlink records');
        foreach ($cells as $cell) {
            $this->assertTrue(in_array($cell['type'], [0x00FD, 0x0201], true), 'Text and metadata must use BIFF shared strings or blank cells');
        }
        $strings = array_map(static fn($key) => mb_convert_encoding(substr($key, 3), 'UTF-8', 'UTF-16LE'), array_keys($writer->_worksheet['Report']->_str_table));
        foreach (array_merge($values, ['=1+1', '@SUM(1,2)', '=2+2', '=3+3', '=4+4', '=5+5']) as $value) {
            $this->assertTrue(in_array($value, $strings, true), 'Preserved literal text: ' . $value);
        }
    }

    public function testExplicitFormulaAndLinkCells()
    {
        $writer = new OA_Admin_ExcelWriter();
        $workbook = new Spreadsheet_Excel_Writer();
        $workbook->setVersion(8);
        $writer->_setExcelWriter($workbook);
        $writer->createReportWorksheet('Report', 'Report', [], []);
        $row = $writer->_currentRow['Report'] + 2;
        $writer->createReportSection('Report', 'Mixed cells', ['Value' => 'text'], [
            [OA_Admin_ExcelWriter::formula('=SUM(B1:B2)')],
            [OA_Admin_ExcelWriter::link('https://example.invalid/', '=1+1')],
            [OA_Admin_ExcelWriter::link('https://example.invalid/')],
            ['=SUM(B1:B2)'],
            ['https://example.invalid/'],
        ]);
        [$types, $cells] = $this->readWorksheetRecords($writer->_worksheet['Report']);
        $this->assertEqual($cells[$row . ':1']['type'], 0x0006, 'Explicit formula produces a FORMULA record');
        foreach ([1, 2, 3, 4] as $offset) {
            $this->assertEqual($cells[($row + $offset) . ':1']['type'], 0x00FD, 'Link labels and ordinary text remain strings');
        }
        $this->assertEqual(count(array_filter($types, static fn($type) => $type === 0x0006)), 1);
        $this->assertEqual(count(array_filter($types, static fn($type) => $type === 0x01B8)), 2);
    }

    public function testNumericAndDateColumnsRemainNumeric()
    {
        $writer = new OA_Admin_ExcelWriter();
        $workbook = new Spreadsheet_Excel_Writer();
        $workbook->setVersion(8);
        $writer->_setExcelWriter($workbook);
        $writer->createReportWorksheet('Report', 'Report', [], []);
        $row = $writer->_currentRow['Report'] + 2;
        $headers = ['Name' => 'text', 'Count' => 'number', 'Amount' => 'decimal', 'Date' => 'datetime', 'Ratio' => 'percent0', 'Id' => 'id', 'Native number' => 'text'];
        $writer->createReportSection('Report', 'Numbers', $headers, [
            ['00123', '42', '-12.5', '45000.5', '0.25', '123', 7],
            [null, '=1+1', '@SUM(1,2)', false, '', 0, 1.5],
            ['0', '0', 0, null, '', 0, 0],
        ]);
        [$types, $cells] = $this->readWorksheetRecords($writer->_worksheet['Report']);
        $this->assertEqual($cells[$row . ':1']['type'], 0x00FD, 'Numeric-looking text retains its string type');
        foreach ([2 => 42, 3 => -12.5, 4 => 45000.5, 5 => 0.25, 6 => 123, 7 => 7] as $col => $value) {
            $this->assertEqual($cells[$row . ':' . $col]['type'], 0x0203);
            $this->assertEqual(unpack('evalue', substr($cells[$row . ':' . $col]['data'], 6))['value'], $value);
        }
        foreach ([2, 3, 4] as $col) {
            $this->assertEqual($cells[($row + 1) . ':' . $col]['type'], 0x00FD, 'Non-numeric input in numeric columns remains literal text');
        }
        foreach ([1, 5] as $col) {
            $this->assertEqual($cells[($row + 1) . ':' . $col]['type'], 0x0201, 'Null and empty strings produce BLANK records');
        }
        $this->assertEqual($cells[($row + 2) . ':1']['type'], 0x00FD, 'String zero remains text');
        foreach ([2, 3, 6, 7] as $col) {
            $this->assertEqual($cells[($row + 2) . ':' . $col]['type'], 0x0203, 'Numeric zero remains numeric');
        }
        foreach ([4 => 'datetime', 5 => 'percent0'] as $col => $format) {
            $cell = $cells[($row + 2) . ':' . $col];
            $this->assertEqual($cell['type'], 0x0201);
            $this->assertEqual(unpack('vformat', substr($cell['data'], 4, 2))['format'], $writer->getFormat([$format, 'border-bottom'])->getXfIndex(), 'Blank cells preserve column formatting');
        }
        $this->assertEqual($cells[($row + 1) . ':6']['type'], 0x0203, 'Zero remains numeric');
        $this->assertFalse(in_array(0x0006, $types), 'Numeric column formatting must not enable formulas');
    }

    private function readWorksheetRecords($worksheet): array
    {
        $data = $worksheet->getData();
        while (($chunk = $worksheet->getData()) !== '') {
            $data .= $chunk;
        }
        $types = [];
        $cells = [];
        for ($offset = 0; $offset + 4 <= strlen($data);) {
            $record = unpack('vtype/vlength', substr($data, $offset, 4));
            $payload = substr($data, $offset + 4, $record['length']);
            $types[] = $record['type'];
            if (in_array($record['type'], [0x00FD, 0x0201, 0x0203, 0x0006], true)) {
                $cell = unpack('vrow/vcol', $payload);
                $cells[$cell['row'] . ':' . $cell['col']] = ['type' => $record['type'], 'data' => $payload];
            }
            $offset += 4 + $record['length'];
        }
        return [$types, $cells];
    }

    /**
     * A method to test the getFormat() method.
     */
    public function testGetFormat()
    {
        $oExcelWriter = new OA_Admin_ExcelWriter();
        $workbook = new Spreadsheet_Excel_Writer();
        $oExcelWriter ->_setExcelWriter($workbook);

        // Test usual case
        $aFormat = [0 => "h1", 1 => "border-top", 2 => "border-left"];
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertIsA($result, 'Spreadsheet_Excel_Writer_Format');

        // One parameter is set to null
        $aFormat = [0 => null, 1 => "border-bottom"];
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertIsA($result, 'Spreadsheet_Excel_Writer_Format');

        // All parameters are set to null
        $aFormat = [0 => null];
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);

        // Empty array
        $aFormat = [];
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);

        // Not array
        $aFormat = null;
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);
    }
}
