<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once PRS_PATH.'/lib/pear/XML/RPC/Server.php';
require_once PRS_PATH.'/ParserReleases.php';


class OX_PluginServer
{
    protected $xmlrpcError;
    protected $psError;

    var $xmlfile;

    function checkForUpdate($params)
    {
        global $XML_RPC_erruser;

        $aParams = XML_RPC_decode($params->getParam(0));

        if (!empty($aParams))
        {
            $name           = $aParams['package'];
            $aReleases      = $this->_parseReleasesXML();

            if (isset($aReleases[$name]))
            {
                $this->_compareVersions($aParams, $aReleases[$name]);
                return new XML_RPC_Response(XML_RPC_encode(
                    $aReleases[$name]
                ));
            }
        }
        if (!empty($this->xmlrpcError))
            return new XML_RPC_Response(XML_RPC_encode($this->xmlrpcError));

        if (!empty($this->psError))
            return new XML_RPC_Response(XML_RPC_encode($this->psError));

        return new XML_RPC_Response(0, $XML_RPC_erruser, "Error: Unknown plugin, unable to check for updates");
    }

    function _compareVersions($aParams, &$aRelease)
    {
        if (version_compare($aRelease['version'],$aParams['version'],'==')) {
            // Check for equal
            $aRelease['status'] = 1;
        } else if (version_compare($aRelease['version'],$aParams['version'],'<')) {
            // Check for older than installed
            $aRelease['status'] = 3;
        } else if (version_compare($aRelease['version'],$aParams['version'],'>')) {
            // Check for newer than installed
            $aRelease['status'] = 0;
            if (!empty($aRelease['oxmaxver']) && version_compare($aParams['oxversion'], $aRelease['oxmaxver'],'>') ) {
                $aRelease['status'] = -1;
            } else if (!empty($aRelease['oxminver']) && version_compare($aParams['oxversion'], $aRelease['oxminver'],'<')) {
                $aRelease['status'] = -2;
            }
        } 
    }

    function _parseReleasesXML()
    {

        if (!file_exists($this->xmlfile))
        {
            $this->_logError('file not found '.$this->xmlfile);
            return false;
        }
        $oParser = new OX_ParserReleases();
        if (!$oParser)
        {
            return false;
        }
        $result = $oParser->setInputFile($this->xmlfile);
        if (PEAR::isError($result)) {
            return $result;
        }
        $result = $oParser->parse();
        if (PEAR::isError($result))
        {
            $this->_logError('problem parsing the releases file: '.$result->getMessage());
            return false;
        }
        if (PEAR::isError($oParser->error))
        {
            $this->_logError('problem parsing the releases file: '.$oParser->error);
            return false;
        }
        return $oParser->aReleases;
    }

    function errorHandler($errno, $errstr, $errfile, $errline)
    {
        global $XML_RPC_erruser;

        if ($errno & (E_ERROR|E_USER_ERROR))
            $this->xmlrpcError = new XML_RPC_Response(0, $XML_RPC_erruser + 100,
                "Error in '$errfile' at line $errline: $errstr");
    }

    function start()
    {
        set_error_handler(array($this, 'errorHandler'));

        $server = new XML_RPC_Server(
            array(
                'OXPS.checkForUpdate' => array(
                    'function' => array($this, 'checkForUpdate'),
                    'signature' => array(
                        array('struct', 'struct')
                        ),
                    ),
                1,
            )
        );
        $server->debug = 0;
        //$server->echoInput();
    }
}

?>
