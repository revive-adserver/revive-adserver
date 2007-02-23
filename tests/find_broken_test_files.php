<?php
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
require_once MAX_PATH . '/lib/simpletest/xml.php';
require_once MAX_PATH . '/tests/testClasses/TestFiles.php';

if ($_SERVER['argc'] < 2) {
   echo "Usage: " . __FILE__ . " php-command (unit|integration)";
   exit(1);
}

$php = $_SERVER['argv'][1];
$layer = $_SERVER['argv'][2];

$reporter = new XmlReporter();
$unit_test_layers = TestFiles::getAllTestFiles($layer);
$reporter->paintGroupStart("Layers", count($unit_test_layers));
foreach ($unit_test_layers as $layer_name => $folders) {
    $reporter->paintGroupStart("$layer_name layer", count($folders));
    foreach ($folders as $folder_name => $files) {
        $reporter->paintCaseStart("Folder $folder_name");
        foreach ($files as $file_name) {
            $reporter->paintMethodStart($file_name);
            $returncode = -1;
            $output_lines = '';
            exec("$php run.php --type=$layer --level=file --layer={$layer_name} --folder={$folder_name} --file={$file_name} --format=text", $output_lines, $returncode);
            $message = "{$file_name}\n" . join($output_lines, "\n");
            switch ($returncode) {
                case 0: $reporter->paintPass($message); break;
                case 1: $reporter->paintFail($message); break;
                default: $reporter->paintException($message);
            }
            $reporter->paintMethodEnd($file_name);
        }
        $reporter->paintCaseEnd("Folder $folder_name");
    }
    $reporter->paintGroupEnd("$layer_name layer");
}
$reporter->paintGroupEnd("Layers");
if ("integration" == $layer && $reporter->getStatus() == false) {
   exit(1);
}
// Consider exiting with a non-zero return code if $reporter->getStatus() shows failures also for unit tests.
?>
