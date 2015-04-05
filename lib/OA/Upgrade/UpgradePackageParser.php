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
 * OpenX Schema Management Utility.
 *
 * Parses an XML schema file
 *
 * @package OpenX
 * @category Upgrade
 */
class OA_UpgradePackageParser extends XML_Parser
{
    var $aPackage       = array('db_pkgs' => array(), 'product'=>'oa');
    var $DBPkg_version  = '';
    var $DBPkg_stamp    = '';
    var $DBPkg_schema   = '';
    var $DBPkg_prescript = '';
    var $DBPkg_postscript = '';
    var $aDBPkgs        = array('files'=>array());
    var $aSchemas       = array();
    var $aFiles         = array();

    var $elements   = array();
    var $element    = '';
    var $count      = 0;
    var $error;

//    function __construct()
//    {
//        // force ISO-8859-1 due to different defaults for PHP4 and PHP5
//        // todo: this probably needs to be investigated some more andcleaned up
//        parent::XML_Parser('ISO-8859-1');
//    }

    function __construct()
    {
        parent::__construct('ISO-8859-1');
        //$this->__construct();
    }

    function startHandler($xp, $element, &$attribs)
    {
        $this->elements[$this->count++] = strtolower($element);
        $this->element = implode('-', $this->elements);

        switch ($this->element) {
        case 'upgrade-database-package':
            $this->DBPkg_version = '';
            $this->DBPkg_stamp = '';
            $this->DBPkg_schema = '';
            $this->DBPkg_prescript = '';
            $this->DBPkg_postscript = '';
            $this->aDBPkgs = array();
            $this->aDBPkgList = array();
//            $this->aFiles = array();
//            $this->aPackage = array();
//            $this->aSchemas = array();
//            $this->aFiles = array();
            break;
          default:
            break;
        }
    }

    function endHandler($xp, $element)
    {
        switch ($this->element) {

        case 'upgrade-database-package':
            $this->aPackage['db_pkgs'][] = array(
                                                 'version' => $this->DBPkg_version,
                                                 'stamp' => $this->DBPkg_stamp,
                                                 'schema' => $this->DBPkg_schema,
                                                 'prescript' => $this->DBPkg_prescript,
                                                 'postscript' => $this->DBPkg_postscript,
                                                 'files'=>$this->aDBPkgs
                                                 );
            break;
        case 'upgrade-database':
            $this->aPackage['db_pkg_list'][$this->DBPkg_schema] = $this->aSchemas;
            break;
        }
        unset($this->elements[--$this->count]);
        $this->element = implode('-', $this->elements);
    }

    function &customRaiseError($msg = null, $xmlecode = 0, $xp = null, $ecode = -1)
    {
        if (is_null($this->error)) {
            $error = '';
            if (is_resource($msg)) {
                $error.= 'Parser error: '.xml_error_string(xml_get_error_code($msg));
                $xp = $msg;
            } else {
                $error.= 'Parser error: '.$msg;
                if (!is_resource($xp)) {
                    $xp = $this->parser;
                }
            }
            if ($error_string = xml_error_string($xmlecode)) {
                $error.= ' - '.$error_string;
            }
            if (is_resource($xp)) {
                $byte = @xml_get_current_byte_index($xp);
                $line = @xml_get_current_line_number($xp);
                $column = @xml_get_current_column_number($xp);
                $error.= " - Byte: $byte; Line: $line; Col: $column";
            }
            $error.= "\n";
            $this->error = PEAR::raiseError($ecode, null, null, $error);
        }
        return $this->error;
    }

    function cdataHandler($xp, $data)
    {

        switch ($this->element)
        {
            case 'upgrade-database-package':
                $this->DBPkg_name = $data;
                break;
            case 'upgrade-database-package-file':
                $this->aDBPkgs[] = $data;
                break;
            case 'upgrade-database-package-prescript':
                $this->DBPkg_prescript = $data;
                break;
            case 'upgrade-database-package-postscript':
                $this->DBPkg_postscript = $data;
                break;
            case 'upgrade-database-package-version':
                $this->DBPkg_version = $data;
                if ($data)
                {
                    $this->aSchemas[] = $this->DBPkg_version;
                }
                break;
            case 'upgrade-database-package-stamp':
                $this->DBPkg_stamp = $data;
                break;
            case 'upgrade-database-package-schema':
                $this->DBPkg_schema = $data;
                break;
            case 'upgrade-name':
                $this->aPackage['name'] = $data;
                break;
            case 'upgrade-type':
                if ($data=='plugin')
                {
                    $this->aPackage['product'] = $this->aPackage['name'];
                }
                break;
            case 'upgrade-creationdate':
                $this->aPackage['creationDate'] = $data;
                break;
            case 'upgrade-author':
                $this->aPackage['author'] = $data;
                break;
            case 'upgrade-authoremail':
                $this->aPackage['authorEmail'] = $data;
                break;
            case 'upgrade-authorurl':
                $this->aPackage['authorUrl'] = $data;
                break;
            case 'upgrade-license':
                $this->aPackage['license'] = $data;
                break;
            case 'upgrade-description':
                $this->aPackage['description'] = $data;
                break;
            case 'upgrade-versionfrom':
                $this->aPackage['versionFrom'] = $data;
                break;
            case 'upgrade-versionto':
                $this->aPackage['versionTo'] = $data;
                break;
            case 'upgrade-prescript':
                $this->aPackage['prescript'] = $data;
                break;
            case 'upgrade-postscript':
                $this->aPackage['postscript'] = $data;
                break;
        }
    }

}

?>
