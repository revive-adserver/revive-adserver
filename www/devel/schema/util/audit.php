<?php
require_once './init.php';
require_once MAX_DEV.'/schema/util/lib/DataObjectAuditTest.inc.php';

$obj = & new DataObjectAuditTest();
$aData = array();

if (array_key_exists('xajax', $_POST))
{
    $aData = $obj->fetchAuditData($_POST['xajaxargs'][0]);
    $_POST['xajaxargs'][1] = $aData;
}
require_once MAX_DEV.'/lib/xajax.inc.php';

if (array_key_exists('clean', $_POST))
{
    $aData = $obj->createTable();
}
else if (array_key_exists('view', $_POST))
{
    $obj->_fetchAuditArrayAll($aData);
}
else if (array_key_exists('agency', $_POST))
{
    $aData = $obj->auditAgency();
}
else if (array_key_exists('zone', $_POST))
{
    $aData = $obj->auditZone();
}
else if (array_key_exists('campaign', $_POST))
{
    $aData = $obj->auditCampaign();
}
else if (array_key_exists('client', $_POST))
{
    $aData = $obj->auditClient();
}
else if (array_key_exists('banner', $_POST))
{
    $aData = $obj->auditBanner();
}
else if (array_key_exists('adzone', $_POST))
{
    $aData = $obj->auditAdZoneAssoc();
}
else if (array_key_exists('dummy', $_POST))
{
    $aData = $obj->auditDummyData();
}

include './tpl/audit.html';
?>