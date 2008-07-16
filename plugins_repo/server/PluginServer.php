<?php

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

        return new XML_RPC_Response(0, $XML_RPC_erruser, "Error");
    }

    function _compareVersions($aParams, &$aRelease)
    {
        if (version_compare($aRelease['version'],$aParams['version'],'=='))
        {
            $aRelease['status'] = 1;
        }
        else if (version_compare($aRelease['version'],$aParams['version'],'>'))
        {
            $aRelease['status'] = 0;
            if (version_compare($aParams['oxversion'], $aRelease['oxmaxver'],'>') )
            {
                $aRelease['status'] = -1;
            }
            else if (version_compare($aParams['oxversion'], $aRelease['oxminver'],'<'))
            {
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
