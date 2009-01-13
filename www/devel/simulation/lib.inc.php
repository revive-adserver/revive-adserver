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

function display_error($message, $data='')
{
    $error = true;
    include TPL_PATH.'/message.html';
}

function check_environment()
{
    if (!folder_is_writable(MAX_PATH.'/var'))
    {
        display_error('Cannot create or save configuration ini file');
    }
    else
    {
        if (!file_exists(MAX_PATH . '/var/' . getHostName() . '.conf.php'))
        {
            copy(MAX_PATH . '/etc/sim.conf.php', MAX_PATH . '/var/' . getHostName() . '.conf.php');
        }
    }
    if (!folder_is_writable(SIM_PATH.'/'.SCENARIOS_DATASETS))
    {
        display_error('You will not be able to save scenarios');
    }
    if (!folder_is_writable(SIM_PATH.'/'.SCENARIOS))
    {
        display_error('You will not be able to save scenarios');
    }
    if (!folder_is_writable(SIM_PATH.'/'.SCENARIOS_REQUESTSETS))
    {
        display_error('You will not be able to save scenarios');
    }
    if (!folder_is_writable(TMP_PATH))
    {
        display_error('You will not be able to save scenarios');
    }
}

function get_conf()
{
    if (!defined('TEST_ENVIRONMENT_RUNNING'))
    {
        define('TEST_ENVIRONMENT_RUNNING', true);
    }
    if (!file_exists(MAX_PATH . '/var/' . getHostName() . '.conf.php'))
    {
        if (folder_is_writable(MAX_PATH.'/var'))
        {
            copy(MAX_PATH . '/etc/sim.conf.php', MAX_PATH . '/var/' . getHostName() . '.conf.php');
        }
    }
    require_once MAX_PATH.'/init-delivery-parse.php';
    $conf = parseIniFile();

    // this is purely because its not used (yet)
    $conf['request']['context'] = '';

    return $conf;
}

function write_sim_ini_file($confAll)
{
    if (array_key_exists('realConfig', $_REQUEST))
    {
        $conf['realConfig']    = $_REQUEST['realConfig'];
    }
    else if (array_key_exists('realConfig', $confAll))
    {
        $conf['realConfig']    = $confAll['realConfig'];
    }
    if (array_key_exists('simdb', $_REQUEST))
    {
        $conf['simdb']    = $_REQUEST['simdb'];
    }
    else if (array_key_exists('simdb', $confAll))
    {
        $conf['simdb']    = $confAll['simdb'];
    }
    if (array_key_exists('scenario', $_REQUEST))
    {
        $conf['scenario'] = $_REQUEST['scenario'];
    }
    else if (array_key_exists('scenario', $confAll))
    {
        $conf['scenario'] = $confAll['scenario'];
    }
    if (array_key_exists('request', $_REQUEST))
    {
        $conf['request']  = $_REQUEST['request'];
    }
    else if (array_key_exists('request', $confAll))
    {
        $conf['request']  = $confAll['request'];
    }
    if (array_key_exists('delivery', $_REQUEST))
    {
        $conf['delivery']  = $_REQUEST['delivery'];
    }
    else if (array_key_exists('delivery', $confAll))
    {
        $conf['delivery']  = $confAll['delivery'];
    }
    if (array_key_exists('delivery', $_REQUEST))
    {
        $conf['logging']  = $_REQUEST['logging'];
    }
    else if (array_key_exists('logging', $confAll))
    {
        $conf['logging']  = $confAll['logging'];
    }
    $content = '';
    if (isset($conf['realConfig']))
    {
        if ($conf['realConfig'])
        {
            $content .= "realConfig = \"{$conf['realConfig']}\"\n";
        }
        unset($conf['realConfig']);
    }
    require_once MAX_PATH.'/lib/max/other/common.php';
    $conf = MAX_commonSlashArray($conf);
    $content = parse_conf_for_ini_file($conf, $content, true);
    if ($handle = fopen(MAX_PATH . '/var/' . getHostName() . '.conf.php', 'w'))
    {
       fwrite($handle, $content);
       fclose($handle);
    }
    return get_conf();
}

function parse_conf_for_ini_file($assoc_arr, $content='', $has_sections=FALSE)
{
   if ($has_sections)
   {
       foreach ($assoc_arr as $key=>$elem)
       {
           if (is_array($elem))
           {
               $content .= "[".$key."]\n";
               foreach ($elem as $key2=>$elem2) {
                   $content .= $key2." = \"".$elem2."\"\n";
               }
           }
           else
           {
                $content .= $key." = \"".$elem."\"\n";
           }
       }
   }
   else
   {
       foreach ($assoc_arr as $key=>$elem)
       {
           $content .= $key." = \"".$elem."\"\n";
       }
   }
   return $content;
}

if (!function_exists('write_ini_file'))
{
   function write_ini_file($assoc_arr, $path, $has_sections=FALSE)
   {
       $content = "";

       if ($has_sections)
       {
           foreach ($assoc_arr as $key=>$elem)
           {
               if (is_array($elem))
               {
                   $content .= "[".$key."]\n";
                   foreach ($elem as $key2=>$elem2) {
                       $content .= $key2." = \"".$elem2."\"\n";
                   }
               }
               else
               {
                    $content .= $key." = \"".$elem."\"\n";
               }
           }
       }
       else
       {
           foreach ($assoc_arr as $key=>$elem)
           {
               $content .= $key." = \"".$elem."\"\n";
           }
       }
       if (!$handle = fopen($path, 'w'))
       {
           return false;
       }
       if (!fwrite($handle, $content))
       {
           return false;
       }
       fclose($handle);
       return true;
   }
}

function get_var_config_files()
{
    $rDIR = opendir(MAX_PATH.'/var/');
    while ($file = readdir($rDIR))
    {
        $i = strpos($file,'.conf.php');
        if ($i && ($i+9==strlen($file)))
        {
            $aFiles[] = substr($file,0,$i);
        }
    }
    return $aFiles;
}


function list_core_tables()
{
    return array(
                'acls',
                'acls_channel',
                'ad_zone_assoc',
                'affiliates',
                'affiliates_extra',
                'banners',
                'campaigns',
                'channel',
                'clients',
                'placement_zone_assoc',
                'zones'
                );
}

function list_maint_tables()
{
 return array('data_intermediate_ad',
             'data_intermediate_ad_connection',
             'data_intermediate_ad_variable_value',
             'data_raw_ad_click',
             'data_raw_ad_impression',
             'data_raw_ad_request',
             'data_raw_tracker_click',
             'data_raw_tracker_impression',
             'data_raw_tracker_variable_value',
             'data_summary_ad_hourly',
             'data_summary_ad_zone_assoc',
             'data_summary_channel_daily',
             'data_summary_zone_impression_history',
             'log_maintenance_forecasting',
             'log_maintenance_priority',
             'log_maintenance_statistics'
             );
}

function get_max_version($dbh, $conf)
{
    $query = "SELECT value FROM {$conf['table']['prefix']}application_variable WHERE name ='max_version'";
    $result = $dbh->getOne($query);

    return $result;
}

function get_sql_insert($dbh, $conf)
{
    $backupFile = TMP_PATH.'/tmp.sql';
    if (file_exists($backupFile))
    {
        unlink($backupFile);
    }
    $ignore = " --ignore-table={$conf['database']['name']}{$conf['table']['prefix']}.application_variable";
    $ignore.= " --ignore-table={$conf['database']['name']}.{$conf['table']['prefix']}preference";
    $ignore.= " --ignore-table={$conf['database']['name']}.{$conf['table']['prefix']}session";
    $aIgnore = list_maint_tables();
    foreach ($aIgnore as $tbl)
    {
        $ignore.= " --ignore-table={$conf['database']['name']}.{$conf['table']['prefix']}{$tbl}";
    }

    $opts = "--compact -c -t -n";
    $command = "mysqldump {$opts} {$ignore}";
    $command.= " -h {$conf['database']['host']}";
    $command.= " -u {$conf['database']['username']}";
    $command.= " -p {$conf['database']['password']}";
    $command.= " {$conf['database']['name']}";
    $command.= " > $backupFile";

    $result = system($command);
    if (file_exists($backupFile))
    {
        return file_get_contents($backupFile);
    }
    else
    {
        return '';
    }
}

function get_sql_truncate()
{
    $sql = '';
    $aTables  = list_maint_tables();
    foreach ($aTables as $k=>$tbl)
    {
        $sql.= "TRUNCATE TABLE `{$tbl}`;\n";
    }
    $aTables  = list_core_tables();
    foreach ($aTables as $k=>$tbl)
    {
        $sql.= "TRUNCATE TABLE `{$tbl}`;\n";
    }
    return $sql;
}

function write_to_file($filename, $buffer)
{
	if ($fp = @fopen($filename, 'wb')) {
		$result = @fwrite($fp, $buffer);
		@fclose($fp);
	}
	else
	{
	    echo $filename.' is not writeable';
	    $result = false;
	}
	return $result;
}

function sim_write_file($relpath, $name, $buffer)
{
    if (!folder_is_writable(SIM_PATH.$relpath))
    {
        exit;
    }
    write_to_file(SIM_PATH.$relpath.'/'.$name, $buffer);
}

function sim_delete_file($relpath, $name)
{
    if (!folder_is_writable(SIM_PATH.$relpath))
    {
        exit;
    }
    unlink(SIM_PATH.$relpath.'/'.$name);
}

function folder_is_writable($abspath)
{
    if (!is_writable($abspath))
    {
        display_error('Folder is NOT writeable.  Check permissions.', $abspath);
        return false;
    }
    return true;
}

function save_scenario($basename, $conf)
{
	$dsn = OA_DB::getDsn($conf);
    $dbh = &OA_DB::singleton($dsn);

    $conf['simdb']['version'] = get_max_version($dbh, $conf);

    $versname = $conf['simdb']['version'].'_'.$basename;
    $sql = get_sql_truncate().strip_prefix(get_sql_insert($dbh, $conf), $conf['table']['prefix']);

    $maintenance_startdate  = date('Y-m-d h:i:s', strtotime("+1 hour" ,strtotime($conf['startdate'])));
    $sql.="INSERT INTO `log_maintenance_statistics` (`log_maintenance_statistics_id`, `start_run`, `end_run`, `duration`, `adserver_run_type`, `search_run_type`, `tracker_run_type`, `updated_to`) VALUES (1, '$maintenance_startdate', '$maintenance_startdate', 0, 2, NULL, NULL, '$maintenance_startdate');";

    $sql.= ($conf['scenario']['resetpriority'] ? "UPDATE `ad_zone_assoc` SET priority=0;\n" : '');
    sim_write_file('/'.FOLDER_DATA, $versname.'.sql', $sql);

    // create request set
    $conf['scenario']['day']  = date('Y-m-d', strtotime($conf['scenario']['startdate']));
    $conf['scenario']['hour'] = date('G', strtotime($conf['scenario']['startdate']));
    $php = file_get_contents(TPL_PATH.'/scenario_config.php.txt');
    foreach ($conf['request'] AS $k=>$v)
    {
        $php = str_replace("conf[request][{$k}]", '"'.$v.'"', $php);
    }
    foreach ($conf['scenario'] AS $k=>$v)
    {
        $php = str_replace("conf[scenario][{$k}]", '"'.$v.'"', $php);
    }
    foreach ($conf['simdb'] AS $k=>$v)
    {
        $php = str_replace("conf[simdb][{$k}]", '"'.$v.'"', $php);
    }
    foreach ($conf['database'] AS $k=>$v)
    {
        $php = str_replace("conf[database][{$k}]", '"'.$v.'"', $php);
    }
    sim_write_file('/'.FOLDER_DATA, $versname.'.php', $php);

    // create child class
    $php = file_get_contents(TPL_PATH.'/scenario_class.php.txt');
    $php = str_replace("<#versname>", $versname, $php);
    $php = str_replace("<#basename>", $basename, $php);

    sim_write_file('/'.FOLDER_SAVE, $basename.'.php', $php);
}

function delete_scenarios($aSims)
{
    foreach ($aSims AS $k => $v)
    {
        $aData = get_simulation_file_list(FOLDER_DATA,'',false,$k);
        foreach ($aData AS $k1 => $v1)
        {
            sim_delete_file('/'.FOLDER_DATA, $v1);
        }
    }
    sim_delete_file('/'.FOLDER_SAVE, $k.'.php');
}


function get_dataset_file_list()
{
    $aFiles = array();
    $dh = opendir(SIM_PATH . "/scenarios/datasets/");
    if ($dh)
    {
        while (false !== ($file = readdir($dh)))
        {
            if (strpos($file, '.xml')>0)
            {
                $aFiles[] = $file;
            }
        }
        closedir($dh);
    }
    natcasesort($aFiles);
    return $aFiles;
}

function get_file_list($directory, $ext, $strip_ext=true)
{
    $aFiles = array();
    $dh = opendir(SIM_PATH . '/'.$directory);
    if ($dh)
    {
        while (false !== ($file = readdir($dh)))
        {
            if (strpos($file, $ext)>0)
            {
                if ($strip_ext)
                {
                    $file = str_replace($ext, '', $file);
                }
                $aFiles[] = $file;
            }
        }
        closedir($dh);
    }
    natcasesort($aFiles);
    return $aFiles;
}

function download_scenarios($aSims)
{
    // Define the PEAR installation path
    require_once MAX_PATH.'/lib/pear/Archive/Tar.php';
    $oTar = new Archive_Tar(TMP_PATH.'/scenarios.tar.gz');
    $aResult = array();
    $aFiles = '';
    foreach ($aSims AS $k => $v)
    {
        $aData = get_simulation_file_list(SCENARIOS_DATASETS,'',false,$k);
        foreach ($aData AS $k1 => $v1)
        {
            $aFiles.= FOLDER_DATA.'/'.$v1.' ';
        }
        $aFiles.= FOLDER_SAVE.'/'.$k.'.php ';
    }
    $tmpdir = getcwd();
    chdir(SIM_PATH);
    $oTar->create($aFiles);
    $aResult = $oTar->listContent();
    chdir($tmpdir);
    return 'scenarios.tar.gz';
}

function upload_scenarios()
{
	if (!array_key_exists('upload', $_FILES) || ($_FILES['upload']['error']['filename']))
	{
		return false;
	}
	else
	{
        $file = $_FILES['upload']['tmp_name'];
	}

    // Define the PEAR installation path
    ini_set('include_path', MAX_PATH . '/lib/pear');
    require_once MAX_PATH.'/lib/pear/Archive/Tar.php';
    $oTar = new Archive_Tar("{$file}");
    $tmpdir = getcwd();
    chdir(SIM_PATH);
    $aResult = $oTar->listContent();
    $oTar->extract();
    chdir($tmpdir);
    unlink($_FILES['upload']['tmp_name']);
    return $aResult;
}

function get_execution_time($start)
{
    list ($endUsec, $endSec) = explode(" ", microtime());
    $endTime = ((float) $endUsec + (float) $endSec);
    list ($startUsec, $startSec) = explode(" ", $start);
    $startTime = ((float) $startUsec + (float) $startSec);
    return substr(($endTime - $startTime), 0, 6);
}

function strip_prefix($source, $prefix='')
{
    $aTables = list_core_tables();
    foreach ($aTables AS $tbl)
    {
        $find   = "/(`{$prefix}{$tbl}`)/U";
        $source = preg_replace($find, '`'.$tbl.'`', $source);
    }
    return $source;
}

function microtime_float()
{
//   list($usec, $sec) = explode(" ", microtime());
//   return ((float)$usec + (float)$sec);
   return array_sum(explode(' ',microtime()));
}

?>
