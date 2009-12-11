<?php

if (!extension_loaded('uuid')) {
    function uuid_create()
    {
        $str = md5(uniqid('', true));
        return preg_replace('/^(........)(....)(....)(....)(............)$/', '$1-$2-$3-$4-$5', $str);
    }
    
    function uuid_is_valid($uuid)
    {
        return (bool) preg_match('/^[0-9a-f]{8}-(?:[0-9a-f]{4}-){3}[0-9a-f]{12}$/Di', $uuid);
    }
}

?>