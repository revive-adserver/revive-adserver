<?php

define('UPMS_PATH', dirname(__FILE__));

ini_set('include_path', '.:'.UPMS_PATH.'/lib:'.UPMS_PATH.'/lib/pear');

require_once('PEAR.php');
require_once('Config.php');
require_once('MDB2.php');


class UpgradePackageManager
{
    /**
     * @var array
     */
    protected $conf;

    /**
     * @var MDB2_Driver_Common
     */
    protected $mdb2;

    protected $logfile;

    function __construct()
    {
        $this->parseConf();

        $this->mdb2 = MDB2::singleton($this->conf['database']);

        $this->mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);

        $this->mdb2->loadModule('Extended');

        $this->logfile = UPMS_PATH.'/log/debug.log';
    }

    function parseConf()
    {
        $oConf = new Config();
        $oConf = $oConf->parseConfig(UPMS_PATH.'/config.ini.php', 'IniCommented');

        $this->conf = $oConf->toArray();
        $this->conf = $this->conf['root'];
        $this->log('UpgradePackageManager::parseConf');
    }

    function log($message)
    {
        $message = '['.date('Y-m-d hh:ii:ss').']'.$message;
        $fh = fopen($this->logfile, 'a');
        if ($fh)
        {
            fwrite($fh, "{$message}\n");
            fclose($fh);
        }
    }

}

?>