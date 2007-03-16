<?php

function testAjax($form)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert('testing ajax');
	$objResponse->addAlert(print_r($form,true));
	return $objResponse;
}

//function loadXmlDropdown($current_file)
//{
//    $objResponse = new xajaxResponse();
//
////    require_once 'oaSchema.php';
//
//    $options = '';
//    foreach ($GLOBALS['oaSchema']->xml_files as $xml_file) {
//        $options .= '<option value="'.htmlspecialchars($xml_file).'"'.($xml_file == $current_file ? ' selected' : '').'>'.htmlspecialchars($xml_file).'</option>';
//    }
//    $objResponse->addAppend('xml_file', 'innerHTML', $options);
////    $objResponse->addEvent('xml_file', 'onchange', 'xmlFileChange()');
//    $objResponse->addScriptCall('xmlFileAddToForms');
//
//    return $objResponse;
//}

function loadChangeset()
{
    $objResponse = new xajaxResponse();
    $changefile = $_COOKIE['changesetFile'];
    $opts = '';
    $dh = opendir(MAX_PATH.'/etc/changes');
    if ($dh) {
        $opts = '<option value="" selected="selected"></option>';
        while (false !== ($file = readdir($dh))) {
            if (strpos($file, '.xml')>0)
            {
                if ($file!=$changefile)
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
        $objResponse->addAssign('select_changesets',"innerHTML", $opts);
    }
	return $objResponse;
}

function loadSchema()
{
    $objResponse = new xajaxResponse();
    $schemaFile = $_COOKIE['schemaFile'];
    $opts = '';
    $dh = opendir(MAX_PATH.'/etc');
    if ($dh) {
        //$opts = '<option value="" selected="selected"></option>';
        while (false !== ($file = readdir($dh))) {
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
    $objResponse->addAssign('btn_tbl_save_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_tbl_exit_'.$id,"style.display", 'inline');
	return $objResponse;
}

function exitTableProperty($form, $elementId)
{
	$objResponse = new xajaxResponse();
	$id = $elementId;
    $objResponse->addAssign('tbl_new_'.$id,"value", '');
	$objResponse->addAssign('tbl_old_'.$id,"style.display", 'inline');
    $objResponse->addAssign('tbl_new_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_tbl_save_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_tbl_exit_'.$id,"style.display", 'none');
	return $objResponse;
}

function editFieldProperty($form, $elementId, $elementNo)
{
	$objResponse = new xajaxResponse();
	$id = $elementId.'_'.$elementNo;
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

require_once MAX_DEV.'/lib/xajax/xajax.inc.php';

$xajax = new xajax();
//$xajax->debugOn(); // Uncomment this line to turn debugging on
$xajax->debugOff(); // Uncomment this line to turn debugging on
$xajax->registerFunction("testAjax");
$xajax->registerFunction('loadChangeset');
$xajax->registerFunction('loadSchema');
//$xajax->registerFunction('loadXmlDropdown');
$xajax->registerFunction('expandTable');
$xajax->registerFunction('collapseTable');
$xajax->registerFunction("editFieldProperty");
$xajax->registerFunction("exitFieldProperty");
$xajax->registerFunction("editTableProperty");
$xajax->registerFunction("exitTableProperty");
$xajax->registerFunction("editIndexProperty");
$xajax->registerFunction("exitIndexProperty");
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

	//$js = "var xml_file = '".addcslashes($current_file, '\'\\')."';\n".
//	      "function xmlFileAddToForms() { var f = document.getElementsByTagName('FORM'); for(var i=0;i<f.length;i++) { if (f[i].id.match(/^frm_(table|schema)_/)) { var c = document.createElement('INPUT'); c.setAttribute('type', 'hidden'); c.setAttribute('name', 'xml_file'); c.setAttribute('value', xml_file); f[i].appendChild(c); }}}\n".
//	      str_replace('devel/schema/index.php', 'devel/schema/index.php?xml_file='.urlencode($current_file), $js);

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