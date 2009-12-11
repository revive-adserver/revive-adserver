<?php

interface OX_UI_Controller_Plugin_LoginPluginDao 
{
    public function getUserBySsoId($ssoId);
    
    public function getUserById($userId);

    public function getAccountById($accountId);
}

