<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
/**
 * OpenX Schema Management Utility
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 *
 * $Id$
 *
 */

function testAjax($form)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert('testing ajax');
	$objResponse->addAlert(print_r($form,true));
	return $objResponse;
}

function loadChangeset()
{
    $objResponse = new xajaxResponse();
    $changeFile = $_COOKIE['changesetFile'];
    $opts = '';
    $aFiles = array();
    $changePath = MAX_CHG;
    global $oaSchema;
    if ($oaSchema)
    {
        $changePath = $oaSchema->path_changes_final;
    }
    $dh = opendir($changePath);
    if ($dh)
    {
        $opts = '<option value="" selected="selected"></option>';
        while (false !== ($file = readdir($dh)))
        {
            if (preg_match('/changes_[\w\W]+_[\d]+\.xml/', $file, $aMatches))
            {
                $aFiles[$file] = '';
            }
        }
        krsort($aFiles);
        foreach ($aFiles AS $file => $null)
        {
            if ($file!=$changeFile)
            {
                $opts.= '<option value="'.$file.'">'.$file.'</option>';
            }
            else
            {
                $opts.= '<option value="'.$file.'" selected="selected">'.$file.'</option>';
            }
        }
        closedir($dh);
        $objResponse->addAssign('select_changesets',"innerHTML", $opts);

        if (is_null($changeFile))
        {
            $objResponse->addAssign('was_edit_field',"style.display", 'none');
            $objResponse->addAssign('was_show_field',"style.display", 'inline');
            $objResponse->addAssign('was_edit_table',"style.display", 'none');
            $objResponse->addAssign('was_show_table',"style.display", 'inline');
            global $oaSchema;
            if ($oaSchema)
            {
                $oaSchema->setWorkingFiles();
                $oaSchema->parseWorkingDefinitionFile();
                $objResponse->addAssign('version',"value", $oaSchema->version);
            }
        }
        else
        {
            $objResponse->addAssign('trans_changeset',"style.display", 'none');
            $objResponse->addAssign('btn_migration_create',"style.display", 'inline');
        }
    }
	return $objResponse;
}

function loadSchema()
{
    global $oaSchema;
    $objResponse = new xajaxResponse();
    $schemaFile = basename($oaSchema->schema_final);
    $opts = '';
    $oaSchema->oLogger->log('xajax: '.$oaSchema->path_schema_final.$schemaFile);
    $dh = opendir($oaSchema->path_schema_final);
    if ($dh)
    {
        while (false !== ($file = readdir($dh)))
        {
            if (strpos($file, '.xml')>0)
            {
                if ($file!=$schemaFile)
                {
                    $opts.= '<option value="'.$file.'">'.$file.'</option>';
                }
                else
                {
                    $opts.= '<option value="'.$file.'" selected="selected">'.$file.'</option>';
                }
            }
        }
        closedir($dh);
        $objResponse->addAssign('xml_file',"innerHTML", $opts);
    }
	return $objResponse;
}

function loadSchemaList()
{
    global $oaSchema, $pluginPath;
    $objResponse = new xajaxResponse();
    $schemaFile = basename($oaSchema->schema_final);
    $opts = '';
    $oaSchema->oLogger->log('xajax: '.$oaSchema->path_schema_final.$schemaFile);
    $relPath = '/etc/';
    $dhCore = opendir(MAX_PATH.$relPath);
    if ($dhCore)
    {
        while (false !== ($file = readdir($dhCore)))
        {
            if (strpos($file, '.xml')>0)
            {
                if ($file!=$schemaFile)
                {
                    $opts.= '<option value="'.$relPath.$file.'">'.$file.'</option>';
                }
                else
                {
                    $opts.= '<option value="'.$relPath.$file.'" selected="selected">'.$file.'</option>';
                }
            }
        }
        closedir($dhCore);
    }
    $dhPkgs = opendir(MAX_PATH.$pluginPath);
    if ($dhPkgs)
    {
        while (false !== ($folder = readdir($dhPkgs)))
        {
            if (($folder=='.') || ($folder=='..') || ($folder=='.svn'))
            {
                continue;
            }
            $relPath = $pluginPath.$folder.'/etc/';
            $dhPlgs = opendir(MAX_PATH.$relPath);
            if ($dhPlgs)
            {
                while (false !== ($file = readdir($dhPlgs)))
                {
                    if (strpos($file, '.xml')>0)
                    {
                        if ($file!=$schemaFile)
                        {
                            $opts.= '<option value="'.$relPath.$file.'">'.$file.'</option>';
                        }
                        else
                        {
                            $opts.= '<option value="'.$relPath.$file.'" selected="selected">'.$file.'</option>';
                        }
                    }
                }
            }
        }
        closedir($dhPkgs);
    }
    $objResponse->addAssign('xml_file',"innerHTML", $opts);
	return $objResponse;
}

function loadDatasetList()
{
    $objResponse = new xajaxResponse();
    $dh = opendir(MAX_PATH.'/tests/datasets/mdb2schema');
    if ($dh)
    {
        while (false !== ($file = readdir($dh)))
        {
            if (strpos($file, '.xml')>0)
            {
                $opts.= '<option value="'.$file.'">'.$file.'</option>';
            }
        }
        closedir($dh);
        $objResponse->addAssign('datafile',"innerHTML", $opts);
    }
	return $objResponse;
}

function expandTable($table)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAssign($table,"style.display", 'block');
	$objResponse->addAssign('img_expand_'.$table,"style.display", 'none');
	$objResponse->addAssign('img_collapse_'.$table,"style.display", 'inline');
	return $objResponse;
}

function collapseTable($table)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAssign($table,"style.display", 'none');
	$objResponse->addAssign('img_expand_'.$table,"style.display", 'inline');
	$objResponse->addAssign('img_collapse_'.$table,"style.display", 'none');
	return $objResponse;
}

function editTableProperty($form, $elementId)
{
	$objResponse = new xajaxResponse();
	$id = $elementId;
	$objResponse->addAssign('tbl_old_'.$id,"style.display", 'none');
    $objResponse->addAssign('tbl_new_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_table_save_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_table_exit_'.$id,"style.display", 'inline');
	return $objResponse;
}

function exitTableProperty($form, $elementId)
{
	$objResponse = new xajaxResponse();
	$id = $elementId;
    $objResponse->addAssign('tbl_new_'.$id,"value", '');
	$objResponse->addAssign('tbl_old_'.$id,"style.display", 'inline');
    $objResponse->addAssign('tbl_new_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_table_save_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_table_exit_'.$id,"style.display", 'none');
	return $objResponse;
}

function editFieldProperty($form, $elementId, $elementNo)
{
	$objResponse = new xajaxResponse();
	//$objResponse->addAlert(print_r($form, true));
	$id = $elementId.'_'.$elementNo;
	//$objResponse->addAlert($id);
	$objResponse->addAssign('fld_old_'.$id,"style.display", 'none');
    $objResponse->addAssign('fld_new_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_field_save_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_exit_'.$id,"style.display", 'inline');
	return $objResponse;
}

function exitFieldProperty($form, $elementId, $elementNo)
{
	$objResponse = new xajaxResponse();
	$id = $elementId.'_'.$elementNo;
    $objResponse->addAssign('fld_new_'.$id,"value", '');
	$objResponse->addAssign('fld_old_'.$id,"style.display", 'inline');
    $objResponse->addAssign('fld_new_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_field_save_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_exit_'.$id,"style.display", 'none');
	return $objResponse;
}

function editIndexProperty($form)
{
	$objResponse = new xajaxResponse();
	$id = $form['index_no'];
	$fid = 'idx['.$id.']';
	$objResponse->addAssign("{$fid}[was]","style.display", 'none');
    $objResponse->addAssign("{$fid}[name]","style.display", 'inline');
    $objResponse->addAssign("{$fid}[was][unique]","style.display", 'none');
    $objResponse->addAssign("{$fid}[unique]","style.display", 'inline');
    $objResponse->addAssign("{$fid}[was][primary]","style.display", 'none');
    $objResponse->addAssign("{$fid}[primary]","style.display", 'inline');
    $n = $form['idx'][$id]['fields'];
    foreach($form['idx'][$id]['fields'] AS $k=>$v)
    {
        $fidx = "idx[{$id}][fields][{$k}]";
        $objResponse->addAssign("span_{$fidx}","style.display", 'none');
        $objResponse->addAssign("edit_{$fidx}","style.display", 'inline');
        if ($n > 1)
        {
            $objResponse->addAssign("{$fidx}[order]","style.display", 'inline');
        }
        $objResponse->addAssign("{$fidx}[sorting]","style.display", 'inline');
    }
    $objResponse->addAssign('btn_idx_save_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_idx_exit_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_idx_edit_'.$id,"style.display", 'none');
	return $objResponse;
}

function exitIndexProperty($form)
{
	$objResponse = new xajaxResponse();
	$id = $form['index_no'];
	$fid = 'idx['.$id.']';
	$objResponse->addAssign("{$fid}[was]","style.display", 'inline');
    $objResponse->addAssign("{$fid}[name]","style.display", 'none');
    $objResponse->addAssign("{$fid}[was][unique]","style.display", 'inline');
    $objResponse->addAssign("{$fid}[unique]","style.display", 'none');
    $objResponse->addAssign("{$fid}[was][primary]","style.display", 'inline');
    $objResponse->addAssign("{$fid}[primary]","style.display", 'none');
    $n = $form['idx'][$id]['fields'];
    foreach($form['idx'][$id]['fields'] AS $k=>$v)
    {
        $fidx = "idx[{$id}][fields][{$k}]";
        $objResponse->addAssign("span_{$fidx}","style.display", 'inline');
        $objResponse->addAssign("edit_{$fidx}","style.display", 'none');
        if ($n > 1)
        {
            $objResponse->addAssign("{$fidx}[order]","style.display", 'none');
        }
        $objResponse->addAssign("{$fidx}[sorting]","style.display", 'none');
    }
    $objResponse->addAssign('btn_idx_save_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_idx_exit_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_idx_edit_'.$id,"style.display", 'inline');
	return $objResponse;
}

function addIndexField($field)
{
	$objResponse = new xajaxResponse();
//	$objResponse->addAlert($field);
//	$html = '<li id="idx_fld_list['.$field.']">'.$field.' => descending? <input type="checkbox" name="idx_fld_add['.$field.'][sorting]" value="1" ></li>';

	$objResponse->addCreateInput('frm_index', 'hidden', "idx_fld_add[{$field}]", "idx_fld_add_{$field}");
    $objResponse->addAssign('idx_fld_add_'.$field, 'value', '');

//	$html = "<li id=\"idx_fld_item[{$field}]\">{$field} => descending?</li>";
//	$objResponse->addAppend('idx_fields', 'innerHTML', $html);

	$objResponse->addCreate("idx_fields", 'li', "idx_fld_item[{$field}]");
	$objResponse->addAssign("idx_fld_item[{$field}]", 'value', $field);
	$objResponse->addAssign("idx_fld_item[{$field}]", 'innerHTML', "{$field} => descending?");

	$objResponse->addCreateInput("idx_fld_item[{$field}]", 'checkbox', "idx_fld_desc[{$field}]", "idx_fld_desc[{$field}]");
	$objResponse->addAssign("idx_fld_desc[{$field}]", 'value', "1");

	return $objResponse;
}

function expandOSURow($id, $oUpgrader)
{
    $oUpgrader->initDatabaseConnection();
    $html = getDBAuditTable($oUpgrader->oAuditor->queryAuditBackupTablesByUpgradeId($id));

	$objResponse = new xajaxResponse();
	$objResponse->addAssign('cell_'.$id,"style.display", 'block');
    $objResponse->addAssign('cell_'.$id, 'text-align', 'center');
	$objResponse->addAssign('cell_'.$id, 'innerHTML', $html);
	$objResponse->addAssign('img_expand_'.$id,"style.display", 'none');
	$objResponse->addAssign('img_collapse_'.$id,"style.display", 'inline');
	$objResponse->addAssign('text_expand_'.$id,"style.display", 'none');
	$objResponse->addAssign('text_collapse_'.$id,"style.display", 'inline');
	return $objResponse;
}

function collapseOSURow($id)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAssign('cell_'.$id,"style.display", 'none');
	$objResponse->addAssign('cell_'.$id, 'innerHTML', '');
	$objResponse->addAssign('img_expand_'.$id,"style.display", 'inline');
	$objResponse->addAssign('img_collapse_'.$id,"style.display", 'none');
	$objResponse->addAssign('text_expand_'.$id,"style.display", 'inline');
	$objResponse->addAssign('text_collapse_'.$id,"style.display", 'none');
	return $objResponse;
}

function expandRow($id, $aRow)
{
    $actionid = $aRow['actionid'];
    unset($aRow['actionid']);
    $html = '';
    foreach ($aRow as $k => $v)
    {
        if ($actionid == OA_AUDIT_ACTION_UPDATE)
        {
            $html.= $k.'='.$v['is'].' (was '.$v['was'].')<br />';
        }
        else
        {

            $html.= $k.'='.$v.'<br />';
        }
    }
	$objResponse = new xajaxResponse();
	$objResponse->addAssign('col_'.$id, 'innerHTML', $html);
	$objResponse->addAssign('row_'.$id,"style.display", 'block');
	$objResponse->addAssign('img_expand_'.$id,"style.display", 'none');
	$objResponse->addAssign('img_collapse_'.$id,"style.display", 'inline');
	return $objResponse;
}

function collapseRow($id)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAssign('col_'.$id, 'innerHTML', '');
	$objResponse->addAssign('row_'.$id,"style.display", 'none');
	$objResponse->addAssign('img_expand_'.$id,"style.display", 'inline');
	$objResponse->addAssign('img_collapse_'.$id,"style.display", 'none');
	return $objResponse;
}



require_once PATH_DEV.'/lib/xajax/xajax.inc.php';

$xajax = new xajax();
//$xajax->debugOn(); // Uncomment this line to turn debugging on
$xajax->debugOff(); // Uncomment this line to turn debugging on
$xajax->registerFunction("testAjax");
$xajax->registerFunction('loadChangeset');
$xajax->registerFunction('loadSchema');
$xajax->registerFunction('loadSchemaList');
$xajax->registerFunction('loadSchemaFile');
$xajax->registerFunction('loadDatasetList');
$xajax->registerFunction('expandTable');
$xajax->registerFunction('collapseTable');
$xajax->registerFunction("editFieldProperty");
$xajax->registerFunction("exitFieldProperty");
$xajax->registerFunction("editTableProperty");
$xajax->registerFunction("exitTableProperty");
$xajax->registerFunction("editIndexProperty");
$xajax->registerFunction("exitIndexProperty");
$xajax->registerFunction("addIndexField");
$xajax->registerFunction("expandOSURow");
$xajax->registerFunction("collapseOSURow");
$xajax->registerFunction("collapseRow");
$xajax->registerFunction("expandRow");

// Process any requests.  Because our requestURI is the same as our html page,
// this must be called before any headers or HTML output have been sent
$xajax->processRequests();

$overwrite=true;

$jsfile = getcwd().'/schema.js';
if (!file_exists($jsfile) || $overwrite)
{
    ob_start();
    $xajax->printJavascript('../lib/xajax/'); // output the xajax javascript. This must be called between the head tags
    $js = ob_get_contents();
    ob_end_clean();

    $pattern    = '/(<script type="text\/javascript">)(?P<jscript>[\w\W\s]+)(<\/script>)/U';
	if (preg_match($pattern, $js, $aMatch))
	{
        $js = $aMatch['jscript'];
	}
	else
	{
        echo "Error parsing javascript generated by xAjax.  You should check the {$jsfile} manually.";
	}

    $fp = fopen($jsfile, 'w');
    if ($fp === false) {
        echo "Error opening output file {$jsfile} for writing.  Check permissions.";
        die();
    }
    else
    {
        fwrite($fp, $js);
        fclose($fp);
    }
}


?>
