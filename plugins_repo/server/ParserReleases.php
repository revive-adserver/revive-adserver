<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
            case 'releases-package-name':
            case 'releases-package-creationdate':
            case 'releases-package-author':
            case 'releases-package-authoremail':
            case 'releases-package-authorurl':
            case 'releases-package-license':
            case 'releases-package-description':
            case 'releases-package-version':
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
