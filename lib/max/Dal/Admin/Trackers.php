<?php

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Trackers extends MAX_Dal_Common
{
    var $table = 'trackers';
    
    var $orderListName = array(
        'name' => 'trackername',
        'id'   => 'trackerid'
    );

}

?>