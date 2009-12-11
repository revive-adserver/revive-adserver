<?php 
require_once '../../../../../init.php';
require_once '../../../config.php';
// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

require '../application/bootstrap.php'; 
