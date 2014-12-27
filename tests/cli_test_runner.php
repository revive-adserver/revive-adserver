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

/**
 * A command-line tool for finding broken tests.
 *
 * Identifies failures and those that cannot execute because of fatal errors.
 *
 * @since 07-Dec-2006
 *
 * @todo Consider implementing as a subclass of UnitTestCase, instead of calling
 * scorer manually. This would allow other outputs, as well as inclusion in
 * other test suites.
 *
 * @todo Consider running over all types, not just 'unit'.
 */

require_once 'init.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/tests/xmlreporter.php';
require_once MAX_PATH . '/tests/testClasses/TestFiles.php';

if ($_SERVER['argc'] < 2) {
   echo "Usage: " . __FILE__ . " php-command [unit|integration]";
   exit(1);
}

$php = $_SERVER['argv'][1];

$testName = isset($_SERVER['argv'][2]) ? $_SERVER['argv'][2] : "";

$aLayer = array(
    'unit',
    'integration'
);

// Take a copy in memory of the conf file
$testConfFile =dirname(__FILE__).'/../var/test.conf.php';
$testConf = file_get_contents($testConfFile);

$oReporter = new ReviveXmlReporter();
$oReporter->paintGroupStart("Tests", count($aLayer));
foreach ($aLayer as $layer) {
    $aTestFiles = TestFiles::getAllTestFiles($layer);
    $oReporter->paintGroupStart("Layer $layer", count($aTestFiles));
    foreach ($aTestFiles as $subLayer => $aDirectories) {
        $oReporter->paintGroupStart("Sublayer $subLayer", count($aDirectories));
        foreach ($aDirectories as $dirName => $aFiles) {
            $oReporter->paintGroupStart("Directory $dirName ($testName)", count($aFiles));
            foreach ($aFiles as $fileName) {
                $oReporter->paintCaseStart("File $fileName ($testName)");

                // Prepare the name of the test to display when running
                for ($counter = 0; $counter < count($GLOBALS['_MAX']['TEST']['groups']) - 1; $counter++) {
                    if ($layer == $GLOBALS['_MAX']['TEST']['groups'][$counter]) {
                        $layerDisplayName = $GLOBALS['_MAX']['TEST'][$GLOBALS['_MAX']['TEST']['groups'][$counter] . '_layers'][$subLayer][0];
                    }
                }
                $testDisplayName = "{$dirName}/tests/{$layer}/{$fileName}";
                $oReporter->paintMethodStart($testDisplayName);

                // Restore conf file to make sure each test runs with a clean one
                file_put_contents($testConfFile, $testConf);

                $returncode = -1;
                $output_lines = '';
                $exec = "run.php --type=$layer --level=file --layer=$subLayer --folder=$dirName"
                    . " --file=$fileName --format=text --host=test 2>&1";
                exec("$php $exec", $output_lines, $returncode);
                $message = "{$fileName}\n" . join($output_lines, "\n");
                switch ($returncode) {
                    case 0: $oReporter->paintPass($message); break;
                    default:
                        $message = "Unexpected return code {$returncode}\n".$message;
                    case 1:
                        $message = "Directory: ".dirname(__FILE__)."\nFailed command: $php $exec\n".$message;
                        $oReporter->paintFail($message);
                        break;
                }
                $oReporter->paintMethodEnd($testDisplayName);
                $oReporter->paintCaseEnd("File $fileName");
            }
            $oReporter->paintGroupEnd("Directory $dirName");
        }
        $oReporter->paintGroupEnd("Sublayer $subLayer");
    }
    $oReporter->paintGroupEnd("Layer $layer");
}
$oReporter->paintGroupEnd("Tests");

if ($oReporter->getStatus() == false) {
   exit(1);
}

?>
