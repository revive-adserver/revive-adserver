<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Max Media Manager pre-test environment set-up</title>
</head>
<body>
<?php
chdir('../../../tests');
require_once 'init.php';
require_once MAX_PATH . '/tests/testClasses/TestRunner.php';
require_once MAX_PATH . '/tests/testClasses/TestEnv.php';


function _printHtmlForVariableArray($variables_array)
{
    print "<table>";
    print "<tr><th>Variable</th><th>Value</th></tr>";
    foreach($variables_array as $variable_id => $variable_value) {
        _printHtmlForVariable($variable_id, $variable_value);
    }
    print "</table>";
}

function _printHtmlForVariable($variable_id, $variable_value)
{
    print "
           <tr>
               <td><label for='$variable_id'>$variable_id</label></td>
               <td><input name='$variable_id' id='$variable_id' type='text' value='$variable_value' /></td>
           </tr>";
}

$valid_scenarios = array('just_installed', 'one_of_each', 'two_of_each');
$scenario_name = addslashes($_GET['scenario']);
assert(in_array($scenario_name, $valid_scenarios));

$conf = $GLOBALS['_MAX']['CONF'];

$output_variables = array();
$output_variables['admin_username'] = 'admin';
$output_variables['admin_password'] = 'admin';
$output_variables['db_host'] = $conf['database']['host'];
$output_variables['db_username'] = $conf['database']['username'];

TestEnv::setupDb();
echo "Created new database.";

// don't do this for the "empty database" scenario
TestEnv::setupCoreTables();

if ($scenario_name == 'just_installed') {
    TestEnv::loadData('0.3.30_JustInstalled_admin', 'insert');
    echo "Loaded just-installed data state.";
}
if ($scenario_name == 'one_of_each' || $scenario_name == 'two_of_each') {
    // XXX: What's more maintainable, individual monolithic data sets or smaller dependant sets?
    TestEnv::loadData('0.3.30_JustInstalled_admin', 'insert');
    TestEnv::loadData('0.3.30_OneOfEach_admin', 'insert');
    echo "Loaded one publisher, zone, advertiser, campaign, banner and agency.";
}
if ($scenario_name == 'two_of_each') {
    TestEnv::loadData('0.3.30_TwoOfEach_admin', 'insert');
    echo "Loaded additional publishers, zones, advertisers, campaigns, banners and agencies.";
}
_printHtmlForVariableArray($output_variables);
?>
<p>Max state has been configured. You can continue to the Max Media Manager <a href="/">admin interface</a>.</p>
</body>
</html>