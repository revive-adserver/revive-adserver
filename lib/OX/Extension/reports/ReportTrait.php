<?php

trait ReportTrait
{
    /**
     * The name of the plugin.
     *
     * @var string
     */
    protected $_name;

    /**
     * The description of the plugin.
     *
     * @var string
     */
    protected $_description;

    /**
     * The report category (eg. "admin", "standard").
     *
     * @var string
     */
    protected $_category;

    /**
     * The name of the report category.
     *
     * @var string
     */
    protected $_categoryName;

    /**
     * The name of the author.
     *
     * @var string
     */
    protected $_author;

    /**
     * The report writer to use for generating reports.
     *
     * @var object
     */
    protected $_oReportWriter;

    /**
     * A variable to decide if the big red TZ inaccuracy warning box should be displayed
     *
     * @var bool
     */
    protected $_displayInaccurateStatsWarning = false;

    /**
     * A method to set the report writer object to use when generating reports.
     *
     * @param object $oWriter The report writer to use.
     */
    public function useReportWriter($oWriter)
    {
        $this->_oReportWriter = $oWriter;
    }

    /**
     * A method to obtain statistics for reports from the same statistics controllers
     * that are used in the UI, but without formatting or paging data, and return
     * the section headers and data independently.
     *
     * @param string $controllerType The required OA_Admin_Statistics_Common type.
     * @param OA_Admin_Statistics_Common $oStatsController An optional parameter to pass in a
     *              ready-prepared stats controller object, to be used instead of creating
     *              and populating the stats.
     * @return array An array containing headers (key 0) and data (key 1)
     */
    public function getHeadersAndDataFromStatsController($controllerType, $oStatsController = null)
    {
        if (is_null($oStatsController)) {
            $oStatsController = OA_Admin_Statistics_Factory::getController(
                $controllerType,
                [
                    'skipFormatting' => true,
                    'disablePager' => true
                ]
            );
            if (PEAR::isError($oStatsController)) {
                return ['Unkcown Stats Controller ', [$oStatsController->getMessage()]];
            }
            $oStatsController->start();
        }
        $aStats = $oStatsController->exportArray();
        $aHeaders = [];
        foreach ($aStats['headers'] as $k => $v) {
            $aHeaders[$v] = match ($aStats['formats'][$k]) {
                'default' => 'numeric',
                'currency' => 'decimal',
                'percent', 'date', 'time' => $aStats['formats'][$k],
                default => 'text',
            };
        }
        $aData = [];
        foreach ($aStats['data'] as $i => $aRow) {
            foreach ($aRow as $k => $v) {
                $aData[$i][] = $aStats['formats'][$k] == 'datetime' ? $this->_oReportWriter->convertToDate($v) : $v;
            }
        }
        return [$aHeaders, $aData];
    }

    /**
     * A private method to create a new report worksheet and fill it with
     * the supplied tabular data.
     *
     * @param string $worksheet The name of the worksheet to be created.
     * @param array  $aHeaders  An array of column headings for the data.
     * @param array  $aData     An array of arrays of data.
     * @param string $title     An optional title for the worksheet.
     */
    public function createSubReport($worksheet, $aHeaders, $aData, $title = '')
    {
        // Use the name of the worksheet as the worksheet's title, if
        // no title supplied
        if ($title == '') {
            $title = $worksheet;
        }

        // check if worksheet name is <= 31 chracters, if so trim because PEAR errors out
        if (strlen($worksheet) >= 31) {
            $worksheet = substr($worksheet, 0, 30);
        }

        $this->_oReportWriter->createReportWorksheet(
            $worksheet,
            $this->_name,
            $this->_getReportParametersForDisplay(),
            $this->_getReportWarningsForDisplay()
        );
        $this->_oReportWriter->createReportSection($worksheet, $title, $aHeaders, $aData, 30, null);
    }

    public function _getReportWarningsForDisplay()
    {
        $aWarnings = [];
        if ($this->_displayInaccurateStatsWarning) {
            $aWarnings[] = $GLOBALS['strWarningInaccurateReport'];
        }

        return $aWarnings;
    }
}
