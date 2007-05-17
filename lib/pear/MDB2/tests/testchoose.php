<?php

// BC hack to define PATH_SEPARATOR for version of PHP prior 4.3
if (!defined('PATH_SEPARATOR')) {
    if (defined('DIRECTORY_SEPARATOR') && DIRECTORY_SEPARATOR == "\\") {
        define('PATH_SEPARATOR', ';');
    } else {
        define('PATH_SEPARATOR', ':');
    }
}
ini_set('include_path', '..'.PATH_SEPARATOR.ini_get('include_path'));

require_once 'PHPUnit.php';
require_once 'test_setup.php';
require_once 'testUtils.php';

$output = '';
foreach ($testcases as $testcase) {
    include_once $testcase.'.php';
    $output.= '<fieldset>'."\n";
    $output.= '<legend><input type="checkbox" id="selectAll_'.$testcase.'" onclick="return checkAll(\''.$testcase.'\');" /> <b>TestCase : '.$testcase.'</b></legend>'."\n";
    $testmethods[$testcase] = getTests($testcase);
    foreach ($testmethods[$testcase] as $method) {
        $output.= testCheck($testcase, $method);
    }
    $output.= "</fieldset><br />\n\n";
    $output.= "<input name=\"submit\" type=\"submit\"><br /> <br />\n\n";
}

?>
<html>
<head>
<title>MDB2 Tests</title>
<link href="tests.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
<!--
function checkAll(testcase)
{
    var boolValue = document.getElementById('selectAll_'+testcase).checked;
    var substr_name = "testmethods[" + testcase + "]";
    var substr_len = substr_name.length;
    for (var i=0; i<document.getElementsByTagName('input').length; i++)
    {
        var e = document.getElementsByTagName('input').item(i);
        if (e.getAttribute('type') == 'checkbox') {
            if (e.name.substr(0, substr_len) == substr_name) {
                e.checked = boolValue;
            }
        }
    }
}
// -->
</script>
</head>
<body>

<form id="testchooseForm" name="testchooseForm" method="post" action="test.php">
<?php
echo($output);
?>

</form>
</body>
</html>