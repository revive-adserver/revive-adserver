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

require_once LIB_PATH . '/Plugin/PluginManager.php';

class OX_PluginExport
{
    var $oPluginManager;

    //var $baseDir;
    var $outputDir;
    var $pathPackages;
    var $pathPlugins;
    var $pathAdmin;
    //var $aDirList     = array();
    var $aFileList    = array();
    var $aSchemas     = array();
    var $aSettings    = array();
    var $aPreferences = array();
    var $aPlugin      = array();
    var $aGroups      = array();
    var $aErrors      = array();

    function __construct()
    {
        $this->basePath = MAX_PATH;
    }

    function init($name)
    {
        $this->clean();

        $this->oPluginManager   = new OX_PluginManager();

        $this->outputDir        = $this->basePath.'/var/plugins/export/';
        if (!file_exists($this->outputDir))
        {
            if (!$this->_makeDirectory($this->outputDir))
            {
                $this->aErrors[] = 'unable to create export directory '.$this->outputDir;
                return false;
            }
        }
        if (!$this->oPluginManager->_parsePackage($name))
        {
            $this->aErrors = $this->oPluginManager->aErrors;
            return false;
        }
        $this->aPlugin = &$this->oPluginManager->aParse['package'];
        if (!$this->oPluginManager->_parseComponentGroups($this->aPlugin['install']['contents']))
        {
            $this->aErrors = $this->oPluginManager->aErrors;
            return false;
        }
        $this->aGroups = &$this->oPluginManager->aParse['plugins'];
        return true;
    }

    function clean()
    {
        //$this->baseDir          = '';
        //$this->aDirList         = array();
        $this->aErrors          = array();
        $this->aFileList        = array();
        $this->aGroups          = array();
        $this->aPlugin          = array();
        $this->aSchemas         = array();
        $this->aSettings        = array();
        $this->aPreferences     = array();
        $this->pathPackages     = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $this->pathPlugins      = $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'];
        $this->pathAdmin        = $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'];
    }

    function _compileContents($name)
    {
        if (!$this->init($name))
        {
            return false;
        }

        // get the filelist
        foreach ($this->aGroups as $i => $aGroup)
        {
            // get the group definition file
            $this->_addToFileList($this->pathPackages.$aGroup['name'].'/'.$aGroup['name'].'.xml');
            $this->_getDeclaredFiles($aGroup['install']['files'], $aGroup['name']);
            $this->_getScriptFiles($aGroup);
            $this->_getChangesetFiles($aGroup);
            $this->_getSchemaFiles($aGroup['install']['schema'], $aGroup['name']);
            // get the settings and export the array to var/plugins/tmp/export/$name
            // get the preferences and export the data to var/plugins/tmp/export/$name
        }
        // get the plugin definition file
        $this->_addToFileList($this->pathPackages.$this->aPlugin['name'].'.xml');
        // get the plugin filelist
        $this->_getDeclaredFiles($this->aPlugin['install']['files'], $this->aPlugin['name']);
    }

    function exportPlugin($name)
    {
        $this->_compileContents($name);
        if (!($result = $this->_compressFiles($name)))
        {
            return false;
        }
        return $result;
    }

    function backupTables($name)
    {
        foreach ($this->aGroups as $aGroup)
        {
            $path = $this->pathPackages.$aGroup['name'].'/etc/';
            if ($aGroup['install']['schema']['mdb2schema'])
            {
                $aSchemas[$aGroup['name']] = $path.$aGroup['install']['schema']['mdb2schema'].'.xml';
            }
        }
        if ($aSchemas)
        {
            $oDbh   = OA_DB::singleton();
            switch ($oDbh->dbsyntax)
            {
                case 'mysql':
                    $engine = $oDbh->getOption('default_table_type');
                    $sql = "CREATE TABLE %s ENGINE={$engine} (SELECT * FROM %s)";
                    break;
                case 'pgsql':
                    $sql = 'CREATE TABLE "%1$s" (LIKE "%2$s" INCLUDING DEFAULTS); INSERT INTO "%1$s" SELECT * FROM "%2$s"';
                    break;
            }

            $prefix  = $GLOBALS['_MAX']['CONF']['table']['prefix'];
            foreach ($aSchemas as $group => $file)
            {
                $oTable = new OA_DB_Table();
                if ($oTable->init($this->basePath.$file, false))
                {
                    foreach ($oTable->aDefinition['tables'] as $table => $aTable)
                    {
                        $tblSrc = $prefix.$table;
                        $tblTgt = $tblSrc.'_'.date('Ymd_His');
                        $query  = sprintf($sql, $tblTgt, $tblSrc);
                        $result = $oDbh->exec($query);
                        if (PEAR::isError($result))
                        {
                            $aResult[] = $group.' : '.$tblSrc.' backup failed';
                            $this->aErrors[] = 'error creating backup '.$tblSrc.' : '.$result->getUserInfo();
                        }
                        if (count(OA_DB_Table::listOATablesCaseSensitive($tblTgt) == 1))
                        {
                            $aResult[] = $group.' : '.$tblSrc.' copied to '.$tblTgt;
                        }
                    }
                }
                else
                {
                    $aResult = $group.' : no tables copied';
                    $this->aErrors[] = 'error initialising '.$group.' schema '.$file;
                }
            }
        }
        return ($aResult ? $aResult : array(0=>'plugin has no tables to backup'));
    }

    function _compressFiles($name)
    {
		require_once( MAX_PATH . '/lib/pclzip/pclzip.lib.php' );
    	define('OS_WINDOWS',((substr(PHP_OS, 0, 3) == 'WIN') ? 1 : 0));

        $target = $this->outputDir.$name.'.zip';
		$oZip = new PclZip($target);

		$result = $oZip->create($this->aFileList, PCLZIP_OPT_REMOVE_PATH, $this->basePath);
		if($oZip->errorCode())
		{
		    $this->aErrors[] = 'compression error: '.$oZip->errorName(true);
			return false;
		}
		if ((!$result) || (!count($result)))
		{
		    $this->aErrors[] = 'no files were compressed';
			return false;
		}
		//$aContents = $oZip->listContent();
		$error = (!file_exists($target));
		if (!$error)
		{
            foreach ($result as $i => $aInfo)
            {
                if ($aInfo['status'] != 'ok')
                {
                    switch ($aInfo['status'])
                    {
                        case 'filename_too_long':
                        case 'write_error':
                        case 'read_error':
                        case 'invalid_header':
                            $this->aErrors[] = 'Error: '.$aInfo['status'].' : '.$aInfo['filename'];
                            $error = true;
                            break;
                        case 'filtered':
                        case 'skipped':
                        default:
                            break;
                    }
                }
            }
		}
        return ($error ? false : $target);
    }

    function _getSchemaFiles($aSchema, $name)
    {
        $path = $this->pathPackages.$name.'/etc/';
        if ($aSchema['mdb2schema'])
        {
            $this->_addToFileList($path.$aSchema['mdb2schema'].'.xml');
        }
        if ($aSchema['dboschema'])
        {
            $this->_addToFileList($path.'DataObjects/'.$aSchema['dboschema'].'.ini');
        }
        if ($aSchema['dbolinks'])
        {
            $this->_addToFileList($path.'DataObjects/'.$aSchema['dbolinks'].'.ini');
        }
        foreach ($aSchema['dataobjects'] as $k => $file)
        {
            $this->_addToFileList($path.'DataObjects/'.$file);
        }
    }

    function _getScriptFiles($aGroup)
    {
        $path = $this->pathPackages.$aGroup['name'].'/etc/';
        if ($aGroup['install']['prescript'])
        {
            $this->_addToFileList($path.$aGroup['install']['prescript']);
        }
        if ($aGroup['install']['postscript'])
        {
            $this->_addToFileList($path.$aGroup['install']['postscript']);
        }
        if ($aGroup['uninstall']['prescript'])
        {
            $this->_addToFileList($path.$aGroup['uninstall']['prescript']);
        }
        if ($aGroup['uninstall']['postscript'])
        {
            $this->_addToFileList($path.$aGroup['uninstall']['postscript']);
        }
    }

    function _getChangesetFiles($aGroup)
    {
        $changesDir    = $this->pathPackages.$aGroup['name'].'/etc/changes/';
        if (file_exists($this->basePath.$changesDir))
        {
            $dh = opendir($this->basePath.$changesDir);
            if ($dh)
            {
                while (false !== ($file = readdir($dh)))
                {
                    if (substr($file,0,1) != '.')
                    {
                        $this->_addToFileList($changesDir.$file);
                    }
                }
                closedir($dh);
            }
        }
    }

    function _getDeclaredFiles($aFiles, $name)
    {
        foreach ($aFiles as $n => $aFile)
        {
            $this->_addToFileList($this->oPluginManager->_expandFilePath($aFile['path'], $aFile['name'], $name));
        }
    }

    function _addToFileList($file)
    {
        $file = DIRECTORY_SEPARATOR . ltrim($file, '\\/');
        $this->aFileList[] = $this->basePath.$file;
        //$this->aDirList[] = dirname($file);
    }

    /**
     * This is a little redundent now that mkdir has the "recursive" flag...
     *
     * @param string $dir The path to be created
     * @return boolean true if the path was created, false otherwise
     */
    function _makeDirectory($dir)
    {
        if (@mkdir($dir, 0775, true)) {
            return true;
        }
        return false;
    }

    /*
    function _compileDirectories($pluginName)
    {
        $this->aDirList[] = rtrim($this->pathPlugins,'/');
        $this->aDirList[] = rtrim($this->pathPackages,'/');
        $this->aDirList = array_unique($this->aDirList);
    }

    function _makeDirectories()
    {
        if (!file_exists($this->baseDir))
        {
            if (!$this->_makeDirectory($this->baseDir))
            {
                $this->aErrors[] = 'failed to create directory '.$baseDir;
                return false;
            }
        }
        foreach ($this->aDirList as $dir)
        {
            if (!file_exists($dir))
            {
                if (!$this->_makeDirectory($this->baseDir.$dir))
                {
                    $this->aErrors[] = 'failed to create directory '.$dir;
                    return false;
                }
            }
        }
    }

    function _copyFiles()
    {
        foreach ($this->aFileList as $file)
        {
            if (!file_exists(MAX_PATH.$file))
            {
                $this->aErrors[] = 'failed to find '.MAX_PATH.$file;
                return false;
            }
            if (!@copy(MAX_PATH.$file, $this->baseDir.$file))
            {
                $this->aErrors[] = 'failed to copy '.MAX_PATH.$file.' to '.$this->baseDir.$file;
                return false;
            }
        }
    }
    */

    /*function fetchBannersJoined($fetchmode=MDB2_FETCHMODE_ORDERED)
    {
        $aConf  = $GLOBALS['_MAX']['CONF']['table'];
        $oDbh   = OA_DB::singleton();
        $tblB   = $oDbh->quoteIdentifier($aConf['prefix'].'banners',true);
        $tblD   = $oDbh->quoteIdentifier($aConf['prefix'].'banners_demo');
        $query  = "SELECT * FROM ".$tableB." b"
                 ." LEFT JOIN ".$tableD." d ON b.bannerid = d.banners_demo_id"
                 ." WHERE b.ext_bannertype = '".$this->getComponentIdentifier()."'";
        return $oDbh->queryAll($query, null, $fetchmode);
    }*/

}
?>