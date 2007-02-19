<?php

/**
 * A demonstration of a proposed system for creating a schema upgrade package
 *
 *
 * The demonstration is based on changing a field name in one table

 * Note: 'editing' any other values than those in the steps below will make the demonstration appear to not work
 * thats because its a demonstration, not a working model!
 *
 * Step 1: loads the latest core schema file from 'etc'
 * Step 2: click 'edit' on the acls.bannerid fieldname and change it to 'ad_id'
 * Step 3: click 'save'.  this saves to and loads a new schema file with the next version number
 * Step 4: click 'compare'.  this creates and loads the changeset
 * Step 5: click 'edit' on the acls 'was called' field and change 'ad_id' to 'bannerid'
 * Step 6: click 'save'.  this saves and reloads the changeset
 * Step 7: click 'create instruction set'.  this creates and loads an instructionset
 *
 * The xml data files are mocks of files created by mdb2_schema
 * Makes use of xsl for rendering and xajax library for editing
 *
 * Uses sub-directories for etc, lib and var to make this pkg self-contained
 * Used Pear, Pear::MDB2 and  Pear::MDB2_Schema
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 */

define('MAX_PATH', dirname(__FILE__).'/../..');
define('MAX_ETC', 'etc');
define('MAX_VAR', 'var');
define('MAX_XSL', 'xsl');
define('MAX_PKG', 'etc/pkg');
define('MAX_PEAR', MAX_PATH.'/lib/pear/');
require ('lib/xajax/xajax.inc.php');

function editFieldProperty($form)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert(print_r($form,true));
	foreach ($form as $k => $v)
	{
    	$objResponse->addAssign($k,"style.display", 'inline');
    	$objResponse->addAssign('span_'.$k,"style.display", 'none');
        $objResponse->addAssign('btn_'.$k,"style.display", 'none');
    }
	return $objResponse;
}

function selectDataDictionary($form)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert(print_r($form,true));
    $options = '<option value="id_med">id => mediumint notnull default=0 unsigned autoincrement</option>
<option value="id_med_inc">id_inc => mediumint notnull default=0 unsigned</option>
<option value="name">name => varchar(255) notnull</option>
<option value="desc">description => text notnull</option>';
	foreach ($form as $k => $v)
	{
      	$objResponse->addAssign($k.'_value',"innerHTML", $options);
       	$objResponse->addAssign('span_'.$k,"style.display", 'inline');
	}
	return $objResponse;
}

$xajax = new xajax();
//$xajax->debugOn(); // Uncomment this line to turn debugging on
$xajax->debugOff(); // Uncomment this line to turn debugging on
$xajax->registerFunction("editFieldProperty");
$xajax->registerFunction("selectDataDictionary");
// Process any requests.  Because our requestURI is the same as our html page,
// this must be called before any headers or HTML output have been sent
$xajax->processRequests();

if (array_key_exists('file', $_REQUEST))
{
    $file = MAX_VAR.'/'.$_REQUEST['file'];
//    $xml_file = $file;
//    $xsl_file = MAX_XSL."/mdb2_schema_test.xsl";
//
//    //create processor
//    $xp = xslt_create() or die("Could not create processor");
//
//    //process and echo output
//    if ($result = xslt_process($xp, $xml_file, $xsl_file))
//    {
//        echo $result;
//    }
//    else
//    {
//        echo"An error occurred: " . xslt_error($xp) . "(error code " . xslt_errno($xp) . ")";
//    }
//
//    //free the resources used by the handler
//    xslt_free($xp);
//    exit;

}
else if (array_key_exists('viewdd', $_POST))
{
    $file = MAX_ETC.'/dd.mysql.xml';
}
else if (array_key_exists('viewraw', $_POST))
{
    $file = MAX_VAR.'/'.$_POST['viewraw'].'.xml';
    $xml = file_get_contents($file);
    echo '<textarea cols="100" rows="50">'.$xml.'</textarea>';
    exit();
}
else if (array_key_exists('createpackage', $_POST))
{
    $file = MAX_PKG.'/upgrade_v3.3.99.xml';
}
else if (array_key_exists('createinstructionset', $_POST))
{
    $file = MAX_VAR.'/mdbi_core.xml';
}
else if (array_key_exists('savechangeset', $_POST))
{
    // save as next version xml
    $file = MAX_VAR.'/mdbc_core(2).xml';
}
else if (array_key_exists('compare', $_POST))
{
    $file = MAX_VAR.'/mdbc_core.xml';
}
else
{
    if (array_key_exists('saveschema', $_POST))
    {
        // save as next version xml
        $file = MAX_VAR.'/mdbs_core.xml';
    }
    if (!$file)
    {
        $file = MAX_ETC.'/mdbs_core.xml';
    }
}

header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
readfile($file);
exit();

?>
