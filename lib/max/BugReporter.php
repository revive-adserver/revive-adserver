<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: BugReporter.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Emailer.php';

/**
 * Simple class to package server + client environment and email
 * to target.
 *
 * @author demian@m3.net
 */
class MAX_BugReporter
{
    var $_clientInfo = array();
    var $_serverInfo = array();
    
    function MAX_BugReporter()
    {
        $this->_clientInfo = $this->getClientInfo();
        $this->_serverInfo = $this->getServerInfo();
        $this->_userInfo = $this->getCurrentUserInfo();
    }

    function getServerInfo()
    {
        $aServerInfo = array();
        //  get db info
        $dbh = & MAX_DB::singleton();

        $lastQuery = $dbh->last_query;
        $aServerInfo['lastSql'] = isset($dbh->last_query) ? 
            $dbh->last_query : null;
        $aServerInfo['phpSapi'] = php_sapi_name();
        $aServerInfo['phpOs'] = PHP_OS;
        $aServerInfo['dbType'] = phpAds_dbmsname;
        $aServerInfo['phpVersion'] = PHP_VERSION;
        $aServerInfo['serverPort'] = $_SERVER['SERVER_PORT'];
        $aServerInfo['serverSoftware'] = $_SERVER['SERVER_SOFTWARE'];   
        $aServerInfo['maxVersion'] = MAX_VERSION_READABLE;
        return $aServerInfo;
    }
    
    
    function getClientInfo()
    {
        $aclientInfo = array();
        $aclientInfo['callingURL'] = $_SERVER['SCRIPT_NAME'];
        $aclientInfo['httpReferer'] = $_SERVER['HTTP_REFERER'];
        $aclientInfo['httpUserAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $aclientInfo['remoteAddr'] = $_SERVER['REMOTE_ADDR'];
        return $aclientInfo;
    }
    
    function getCurrentUserInfo()
    {
        // not implemented
    }
    
    function buildEnvironmentReport()
    {
        $html = '';
        $data = array_merge($this->_clientInfo, $this->_serverInfo);
        foreach ($data as $k => $v) {
            $html .= "[$k] => $v \n";   
        }
        return $html;
    }
    
    function buildEmail($report)
    {
        $body = "The following bug report was submitted: \n\n";
        
        $options = array(
            'toEmail'       => 'developers@m3.net',
            'toRealName'    => 'Bug reports list',
            'fromEmail'     => $report->getEmail(),
            'fromRealName'  => $report->getName(),
            'replyTo'       => 'admin@m3.net',
            'subject'       => 'Bug report',
            'body'          => $report->toString(),
            'template'      => MAX_PATH . '/lib/max/resources/emailBugReport.php',
            'username'      => '',
            'siteUrl'       => MAX::constructURL(MAX_URL_ADMIN),
            'siteName'      => 'Max Media Manager',
            'crlf'          => ''
        );
        $email = new MAX_Emailer($options);
        $ret = $email->prepare();
        if (PEAR::isError($ret)) {
            MAX::debug('There was an error preparing the email object', 
                $file, $line); 
        } else {
            return $email;
        }
    }
}

/**
 * Class to encapsulate report data.
 *
 */
class MAX_BugReport
{   
    var $email;
    var $first_name;
    var $last_name;
    var $summary;
    
    function MAX_BugReport($oData)
    {
        foreach ($oData as $k => $v) {
            $this->$k = $v;
        }
    }
    
    function getEmail()
    {
        return isset($this->email) ? $this->email : 'anonymous';
    }
    
    function getName()
    {
        return isset($this->first_name) 
            ? $this->first_name .' '. $this->last_name 
            : 'BugReporter';
    }
    
    function getSummary()
    {
        return isset($this->summary) ? $this->summary : 'no summary';
    }
    
    function toString()
    {
        $str = "{{{\n";
        $data = get_object_vars($this);
        foreach ($data as $k => $v) {
            $str .= "[$k] => $v \n";   
        }
        $str .= "}}}\n";
        return $str;
    }
}

?>
