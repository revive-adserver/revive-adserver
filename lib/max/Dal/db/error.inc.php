<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------

/**
* @package ERROR
* @version $Id: error.inc.php,v 1.1 2004/10/16 18:36:40 jeffmoore Exp $
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
    
    phpAds_sqlDie();
    $errobj =& new ErrorInfo();
    $errobj->group = $group;
    $errobj->id = $id;
    $errobj->info = $info;
    $errorstr = serialize($errobj);
    while (strlen($errorstr) > 1023) {
        $errobj->truncated = TRUE;
        array_pop($errobj->info);
        $errorstr = serialize($errobj);
    }
    trigger_error($errorstr, E_USER_ERROR);
}

function RaiseError($group, $id, $info=NULL) {
    RaiseErrorHandler($group, $id, $info);
}

?>