<?php

require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

abstract class Plugins_Api extends OX_Component
{

    abstract function getDispatchMap();

}