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

require_once 'XML/Parser.php';

/**
 * Parses an XML plugin install file
 *
 * @package OpenX Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 */
class OX_ParserReleases extends XML_Parser
{
    var $aReleases  = array();
    var $aPackage   = array();

    var $aData      = array();

    var $elements = array();
    var $element = '';
    var $count = 0;
    var $error;

    function __construct()
    {
        // force ISO-8859-1 due to different defaults for PHP4 and PHP5
        // todo: this probably needs to be investigated some more andcleaned up
        parent::XML_Parser('ISO-8859-1');
    }

    function OX_ParserReleases()
    {
        $this->__construct();
    }

    private function _initArray()
    {
        $this->aReleases   = array();

        $this->aPackage = array(
                             'name'         => '',
                             'creationdate' => '',
                             'author'       => '',
                             'authoremail'  => '',
                             'authorurl'    => '',
                             'license'      => '',
                             'description'  => '',
                             'version'      => '',
                             'oxminver'     => '',
                             'oxmaxver'     => '',
                             );
    }

    private function _assignArray()
    {
        $this->aReleases[] = $this->aPackage;
    }

    function startHandler($xp, $element, $attribs)
    {
        $this->elements[$this->count++] = strtolower($element);
        $this->element = implode('-', $this->elements);

        switch ($this->element)
        {
            case 'releases':
                $this->_initArray();
                break;
        }
    }

    function endHandler($xp, $element)
    {
        switch ($this->element)
        {
            case 'releases-package':
                $this->aReleases[$this->aPackage['name']] = $this->aPackage;
                break;
        }
        unset($this->elements[--$this->count]);
        $this->element = implode('-', $this->elements);
    }

    function cdataHandler($xp, $data)
    {

        switch ($this->element)
        {
            case 'releases-package-version':
                // Fix potential issues with lowercase RC's
                $this->aPackage['version']= preg_replace('/rc([0-9]+)$/', 'RC$1', $data);
                break;
            case 'releases-package-name':
            case 'releases-package-creationdate':
            case 'releases-package-author':
            case 'releases-package-authoremail':
            case 'releases-package-authorurl':
            case 'releases-package-license':
            case 'releases-package-description':
            case 'releases-package-oxminver':
            case 'releases-package-oxmaxver':
            case 'releases-package-downloadurl':
                $this->aPackage[str_replace('releases-package-','',$this->element)]= $data;
                break;
        }
    }

    function &raiseError($msg = null, $xmlecode = 0, $xp = null, $ecode = -1)
    {
        if (is_null($this->error))
        {
            $error = '';
            if (is_resource($msg))
            {
                $error.= 'Parser error: '.xml_error_string(xml_get_error_code($msg));
                $xp = $msg;
            }
            else
            {
                $error.= 'Parser error: '.$msg;
                if (!is_resource($xp)) {
                    $xp = $this->parser;
                }
            }
            if ($error_string = xml_error_string($xmlecode))
            {
                $error.= ' - '.$error_string;
            }
            if (is_resource($xp))
            {
                $byte = @xml_get_current_byte_index($xp);
                $line = @xml_get_current_line_number($xp);
                $column = @xml_get_current_column_number($xp);
                $error.= " - Byte: $byte; Line: $line; Col: $column";
            }
            $error.= "\n";
            $mode = 0;
            $options = 0;
            $userinfo = '';

            $this->error =& PEAR::raiseError(null, $code, $mode, $options, $userinfo, 'OX_Parserreleases-package_Error', true);
            return $err;

        }
        return $this->error;
    }


}

?>
