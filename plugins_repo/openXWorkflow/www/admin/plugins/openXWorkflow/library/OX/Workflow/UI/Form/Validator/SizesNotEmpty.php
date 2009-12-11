<?php
/**
 * Checks whether at least one zone has been selected in forecasting panels
 */
class OX_Workflow_UI_Form_Validator_SizesNotEmpty
    extends OX_UI_Form_Validate_AbstractFormValidator
{
    const EMPTY_SIZES_LIST = 'emptySizesList';
    const FIELD_IN_ERROR_MARKER = 'fieldInErrorMarker';
    
    protected $_messageTemplates = array(
        self::EMPTY_SIZES_LIST => 'Please select at least one zone size to be used',
        self::FIELD_IN_ERROR_MARKER => '' 
    );
    
    
    /**
     * An array of zone size keys to look for
     *
     * @var OX_Forecasting_UI_ForecastingReportSettings
     */
    private $allSizes;

    
    function __construct(array $allSizes)
    {
        $this->allSizes = $allSizes;
    }
    
    
    /**
     * Check the zone counts against the stored zone size keys. If no zone count is set 
     * to value greater then zero, raise an error.
     *
     * @param unknown_type $value
     * @param unknown_type $aContext
     * @return unknown
     */
    function isValid($data)
    {
        foreach($this->allSizes as $sizeElementName) {
            if (isset($data[$sizeElementName]) && $data[$sizeElementName] >= 1) {
                return true;
            }
            $this->_elementError($sizeElementName, self::FIELD_IN_ERROR_MARKER);
        }

        $this->_formError(self::EMPTY_SIZES_LIST);
        return false;
    }
}

?>