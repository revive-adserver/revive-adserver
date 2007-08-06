<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id$
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
require_once MAX_PATH . '/lib/simpletest/xml.php';
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

$oReporter = new XmlReporter();
$oReporter->paintGroupStart("Tests", count($aLayer));
foreach ($aLayer as $layer) {
    $aTestFiles = TestFiles::getAllTestFiles($layer);
    $oReporter->paintGroupStart("Layer $layer", count($aTestFiles));
    foreach ($aTestFiles as $subLayer => $aDirectories) {
        $oReporter->paintGroupStart("Sublayer $subLayer", count($aDirectories));
        foreach ($aDirectories as $dirName => $aFiles) {
            $oReporter->paintCaseStart("Directory $dirName ($testName)");
            foreach ($aFiles as $fileName) {
                $oReporter->paintMethodStart($fileName);
                $returncode = -1;
                $output_lines = '';
                $exec = "run.php --type=$layer --level=file --layer=$subLayer --folder=$dirName"
                    . " --file=$fileName --format=text --host=test";
                exec("$php $exec", $output_lines, $returncode);
                $message = "{$fileName}\n" . join($output_lines, "\n");
                switch ($returncode) {
                    case 0: $oReporter->paintPass($message); break;
                    case 1:
                        $command = "Failed command (in /tests): php $exec\n";
                        $oReporter->paintFail($command . $message);
                        break;
                    default: $oReporter->paintException($message);
                }
                $oReporter->paintMethodEnd($fileName);
            }
            $oReporter->paintCaseEnd("Directory $dirName");
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
