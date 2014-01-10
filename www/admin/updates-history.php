<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Preliminary check before including config.php to prevent it from outputting HTML code
// in case session is expired
if (!empty($_POST['xajax'])) {
    require_once MAX_PATH . '/www/admin/lib-sessions.inc.php';
    require_once MAX_PATH . '/lib/OA/Permission.php';
    unset($session);
    phpAds_SessionDataFetch();
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
        $_POST['xajax']     = $_GET['xajax']     = $_REQUEST['xajax']     = 'sessionExpired';
        $_POST['xajaxargs'] = $_GET['xajaxargs'] = $_REQUEST['xajaxargs'] = array();
        require_once MAX_PATH . '/lib/xajax.inc.php';
    }
}

// Required files
require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH . '/lib/RV/Sync.php';
require_once MAX_PATH . '/lib/xajax.inc.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

$oUpgrader = new OA_Upgrade();



// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("updates-index");
phpAds_MaintenanceSelection("history", "updates");

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

function getDBAuditTable($aAudit)
{
    $td = "<td class=\"tablebody\">%s</td>";
    $th = "<th align=\"left\" style='background-color: #ddd; border-bottom: 1px solid #ccc;'><b>%s</b></th>";
    $schemas = "<table width='100%' cellpadding='8' cellspacing='0' style='border: 1px solid #ccc; background-color: #eee;'>";
    $schemas.= "<tr>";
    //$schemas.= sprintf($th, 'schema');
    //$schemas.= sprintf($th, 'version');
    $schemas.= sprintf($th, 'Table origin');
    $schemas.= sprintf($th, 'Backup table');
    $schemas.= sprintf($th, 'Size');
    $schemas.= sprintf($th, 'Rows');
    //$schemas.= sprintf($th, 'Delete');
    $schemas.= "</tr>";
    $totalSize = 0;
    $totalRows = 0;
    foreach ($aAudit AS $k => $aRec)
    {
        $schemas.= "<tr>";
        //$schemas.= sprintf($td, $aRec['schema_name']);
        //$schemas.= sprintf($td, $aRec['version']);
        $schemas.= sprintf($td, $aRec['tablename']);
        $schemas.= sprintf($td, $aRec['tablename_backup']);
        $schemas.= sprintf($td, round($aRec['backup_size'] * 10, 2) . ' kb');
        $schemas.= sprintf($td, $aRec['backup_rows']);
        //$schemas.= sprintf($td, "<input type=\"checkbox\" id=\"chk_tbl[{$aRec['database_action_id']}]\" name=\"chk_tbl[{$aRec['database_action_id']}]\" checked />");
        $schemas.= "</tr>";
        $totalSize = $totalSize + $aRec['backup_size'];
        $totalRows = $totalRows + $aRec['backup_rows'];
    }

    $schemas.= "<tr>";
    $schemas.= sprintf($th, 'Total');
    $schemas.= sprintf($th, count($aAudit) . ' tables');
    $schemas.= sprintf($th, round($totalSize * 10, 2) . ' kb');
    $schemas.= sprintf($th, $totalRows);
    //$schemas.= sprintf($th, 'Delete');
    $schemas.= "</tr>";

    $schemas.= "</table>";
    return $schemas;
}

$oUpgrader->initDatabaseConnection();

if (array_key_exists('btn_clean_audit', $_POST))
{
    $upgrade_id = $_POST['upgrade_action_id'];
    $oUpgrader->oAuditor->cleanAuditArtifacts($upgrade_id);
}

$aAudit = $oUpgrader->oAuditor->queryAuditAllDescending();


/*-------------------------------------------------------*/
/* Error handling                                        */
/*-------------------------------------------------------*/

$aErrors = $oUpgrader->getErrors();
if (count($aErrors)>0)
{
?>
<div class='errormessage'><img class='errormessage' src='<?php echo OX::assetPath() ?>/images/errormessage.gif' width='16' height='16' border='0' align='absmiddle'>
    <?php
        foreach ($aErrors AS $k => $err)
        {
            echo $err.'<br />';
        }
    ?>
</div>
<?php
}
$aMessages = $oUpgrader->getMessages();
if (count($aMessages)>0)
{
?>
<div class='errormessage' style='background-color: #eee;'><img class='errormessage' src='<?php echo OX::assetPath() ?>/images/info.gif' width='16' height='16' border='0' align='absmiddle'>
    <?php
        foreach ($aMessages AS $k => $msg)
        {
            echo $msg.'<br />';
        }
    ?>
</div>
<?php
}

/*-------------------------------------------------------*/
/* Display                                               */
/*-------------------------------------------------------*/
?>
        <script type="text/javascript" src="<?php echo OX::assetPath() ?>/js/xajax.js"></script>
        <script type="text/javascript">
        <?php
        include MAX_PATH . '/var/templates_compiled/oxajax.js';
        ?>
        </script>

		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td width='40'>&nbsp;</td>
			<td>
                <br /><br />
                <table border='0' width='90%' cellpadding='0' cellspacing='0'>
                <tr height='25'>
                    <td height='25'>
                        <b style="color: #003399;"><?php echo $strName; ?></b>
                    </td>
                    <td height='25'>&nbsp;</td>
                    <td height="25">
                        <b style="color: #003399;"><?php echo $strFromVersion ?></b>
                    </td>
                    <td height="25">
                        <b style="color: #003399;"><?php echo $strToVersion ?></b>
                    </td>
                    <td height="25">
                        <b style="color: #003399;"><?php echo $strStatus ?></b>
                    </td>
                    <td height='25'>
                        <b style="color: #003399;">Date</b>
                    </td>
                    <td height='25' width='70'>
                        <b style="color: #003399;">&nbsp;</b>
                    </td>
                </tr>
                <tr height='1'>
                    <td colspan='7' bgcolor='#888888'><img src='<?php echo OX::assetPath() ?>/images/break.gif' height='1' width='100%'></td>
                </tr>
                <?php
                $i=0;
                asort($aAudit);
                foreach ($aAudit AS $k => $v)
                {
                    if (($v['backups'] || !empty($v['logfile']) || !empty($v['confbackup'])) && $v['logfile'] != 'cleaned by user' && $v['logfile'] != 'file not found'&& $v['confbackup'] != 'cleaned by user' && $v['confbackup'] != 'file not found')
                    {
                        $v['backupsExist'] = true;
                    }
                ?>
                    <form name="frmOpenads" action="updates-history.php" method="POST">
                    <tr height='25' <?php echo ($i%2==0?"bgcolor='#F6F6F6'":""); ?>>
                        <?php
                            if ($v['backups']) {
                        ?>
                        <td height='25' width='25'>
                            &nbsp;<a href="#" onclick="return false;" title="<?php echo $strToggleDataBackupDetails ?>"><img id="img_expand_<?php echo $v['upgrade_action_id']; ?>" src="<?php echo OX::assetPath() ?>/images/<?php echo $phpAds_TextDirection; ?>/triangle-l.gif" alt="<?php echo $GLOBALS['strClickViewBackupDetails'] ?>" onclick="xajax_expandOSURow('<?php echo $v['upgrade_action_id']; ?>');" border="0" /><img id="img_collapse_<?php echo $v['upgrade_action_id']; ?>" src="<?php echo OX::assetPath() ?>/images/triangle-d.gif" style="display:none" alt="<?php echo $GLOBALS['strClickHideBackupDetails'] ?>" onclick="xajax_collapseOSURow('<?php echo $v['upgrade_action_id']; ?>');" border="0" /></a>
                        </td>
                        <td height='25'>
                            <b>&nbsp;<a href="#" title="<?php echo $strShowBackupDetails ?>" id="text_expand_<?php echo $v['upgrade_action_id']; ?>" onclick="xajax_expandOSURow('<?php echo $v['upgrade_action_id']; ?>');return false;"><?php echo $v['updated']; ?></a><a href="#" title="<?php echo $GLOBALS['strHideBackupDetails'] ?>" id="text_collapse_<?php echo $v['upgrade_action_id']; ?>" style="display:none" onclick="xajax_collapseOSURow('<?php echo $v['upgrade_action_id']; ?>');return false;"><?php echo $v['updated']; ?></a></b>
                        <?php
                            } else {
                        ?>
                            <td colspan="2"><b style="color: #003399;">&nbsp;<?php echo $v['upgrade_name']; ?></a></b></td>
                        <?php
                            }
                        ?>
                        </td>
                        <td height='25'>
                            <?php echo ($v['version_from']) ? $v['version_from'] : '<b>---</b>'; ?>
                        </td>
                        <td height='25'>
                            <?php echo ($v['version_to']) ? $v['version_to'] : '<b>---</b>'; ?>
                        </td>
                        <td height='25'>
                            <span style="text-transform:lowercase;"><?php  echo ($v['upgrade_name'] == 'version stamp') ? $strUpdatedDbVersionStamp : $aProductStatus[$v['description']]; ?></span>
                        </td>
                        <td><b style="color: #003399;">&nbsp;<?php echo $v['updated']; ?></a></b></td>
                        <td height='25' align='right'>
                        </td>
                </tr>
                <tr height='1'><td colspan='2' bgcolor='#F6F6F6'><img src='<?php echo OX::assetPath() ?>/images/spacer.gif' width='1' height='1'></td><td colspan='5' bgcolor='#888888'><img src='<?php echo OX::assetPath() ?>/images/break-l.gif' height='1' width='100%'></td></tr>
                <tr style="display:table-row;" <?php echo ($i%2==0?"bgcolor='#F6F6F6'":""); ?>>
                    <td colspan='2'>&nbsp;</td>
                    <td colspan='5'>
                        <table width='100%' cellpadding='5' cellspacing='0' border='0' style='border: 0px solid #ccc; margin: 10px 0 10px 0; '>
                        <tr height='20'>
                            <td width="275" style="border-bottom: 1px solid #ccc;">
                            <?php echo $strArtifacts ?>:
                            </td>
                            <td width="100" style="border-bottom: 1px solid #ccc;">
                            <?php echo ($v['backups']) ? "<b>" : ""; echo ($v['backupsExist']) ? $v['backups'] + !empty($v['logfile']) + !empty($v['confbackup']) : 0; echo ($v['backups']) ? "</b>" : ""; ?>
                            </td>
                            <td align="right" style="border-bottom: 1px solid #ccc;">
                            <?php
                            if ($v['backupsExist']) {
                            ?>
                                <img src='<?php echo OX::assetPath() ?>/images/icon-recycle.gif' border='0' align='absmiddle' alt='<?php echo $strDelete ?>'><input type="submit" name="btn_clean_audit" onClick="return confirm('<?php echo $strBackupDeleteConfirm ?>')" style="cursor: pointer; border: 0; background: 0; color: #003399;font-size: 13px;" value="<?php echo $strDeleteArtifacts ?>">
                            <?php
                            }
                            else
                            {
                            ?>
                                &nbsp;
                            <?php
                            }
                            ?>
                            </td>
                        </tr>
                        <?php
                        if ($v['backups'])
                        {
                        ?>
                        <tr>
                            <td width="235">
                            <?php echo $strBackupDbTables ?>:
                            </td>
                            <td width="100" colspan="2">
                            <?php echo $v['backups'];?>
                            <a href="#" onclick="return false;" title="<?php echo $strToggleDataBackupDetails ?>"><img id="info_expand_<?php echo $v['upgrade_action_id']; ?>" src="<?php echo OX::assetPath() ?>/images/info.gif" alt="<?php echo $strClickViewBackupDetails ?>" onclick="xajax_expandOSURow('<?php echo $v['upgrade_action_id']; ?>');" border="0" /><img id="info_collapse_<?php echo $v['upgrade_action_id']; ?>" src="<?php echo OX::assetPath() ?>/images/info.gif" style="display:none" alt="<?php echo $strClickHideBackupDetails ?>" onclick="xajax_collapseOSURow('<?php echo $v['upgrade_action_id']; ?>');" border="0" /></a>
                            </td>
                        </tr>
                        <?php
                        }
                        if ($v['logfile'])
                        {
                        ?>
                        <tr height='20'>
                            <td><?php echo $strLogFiles ?>:</td>
                            <td colspan="2">
                            <?php echo $v['logfile']; ?>
                            </td>
                        </tr>
                        <?php
                        }
                        if ($v['confbackup'])
                        {
                        ?>
                        <tr height='20'>
                            <td><?php echo $strConfigBackups ?>:</td>
                            <td colspan="2">
                            <?php echo $v['confbackup']; ?>
                            </td>
                        <?php
                        }
                        ?>
                        </tr>
                        <tr>
                            <td colspan='3'>
                            <div id="cell_<?php echo $v['upgrade_action_id']; ?>"> </div>
                            </td>
                        </tr>
                        </table>
                    </td>
                    <input type="hidden" name="upgrade_action_id" value="<?php echo $v['upgrade_action_id']; ?>" />
                </tr>
              </form>
                <tr height='1'><td colspan='7' bgcolor='#888888'><img src='<?php echo OX::assetPath() ?>/images/break.gif' height='1' width='100%'></td></tr>
                <?php
                    $i++;
                }
                ?>
                <tr height='25'>
                    <td colspan='7' height='25' align='right'>
                    </td>
                </tr>
                </table>
                <br /><br />
            </td>
			<td width='40'>&nbsp;</td>
		</tr>
		<tr>
			<td width='40' height='20'>&nbsp;</td>
			<td height='20'>&nbsp;</td>
		</tr>
		</table>
<?php

/*-------------------------------------------------------*/
/* Footer                                                */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
