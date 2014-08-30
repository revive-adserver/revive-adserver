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
    
    if (function_exists('phpAds_sqlDie')) {
        global $phpAds_last_query;
        $phpAds_last_query = $info['sql'];
        phpAds_sqlDie();
    } else {
        $oError = new ErrorInfo();
        $oError->group = $group;
        $oError->id = $id;
        $oError->info = $info;
        
        $errorstr = sprintf('[%s: message="%s" group=%d id=%s]',
                       strtolower(get_class($oError)), implode(', ', $oError->info), $oError->group, $oError->id);
                       
        trigger_error($errorstr, E_USER_ERROR);
    }
}

function RaiseError($group, $id, $info=NULL) {
    RaiseErrorHandler($group, $id, $info);
}

?>