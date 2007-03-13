<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------

/**
* @package ERROR
*/

/**
* Represents a framework error
* @see http://wact.sourceforge.net/index.php/ErrorInfo
* @access protected
* @package ERROR
*/
class ErrorInfo {
    var $group;
    var $id;
    var $truncated;
    var $info;
}

function RaiseErrorHandler($group, $id, $info=NULL) {
    
    global $phpAds_last_query;
    $phpAds_last_query = $info['sql'];
    if (function_exists('phpAds_sqlDie')) {
        phpAds_sqlDie();
    } else {
        $oError = &new ErrorInfo();
        $oError->group = $group;
        $oError->id = $id;
        $oError->info;
        $errorstr = serialize($oError);
        while (strlen($oError) > 1023) {
            $oError->truncated = true;
            array_pop($oError->info);
            $errorstr = serialize($oError);
        }
        trigger_error($errorstr, E_USER_ERROR);
    }
}

function RaiseError($group, $id, $info=NULL) {
    RaiseErrorHandler($group, $id, $info);
}

?>