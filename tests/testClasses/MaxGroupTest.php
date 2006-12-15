<?php
/**
 * @since 06-Dec-2006
 *
 */
require_once MAX_PATH . '/lib/simpletest/unit_tester.php';

class MaxGroupTest extends GroupTest
{
    /**
     * Constructor
     * 
     * @param string $label
     */
    function MaxGroupTest($label)
    {
        parent::GroupTest($label);
    }

    function _addFilesInFolders($test_folders)
    {
        foreach($test_folders as $test_folder => $test_files) {
            foreach($test_files as $test_file) {
                $test_path_components = array(MAX_PATH, $test_folder, 'tests', 'unit', $test_file);
                $full_test_filename = join($test_path_components, '/');
                $this->addTestFile($full_test_filename);
            }
        }
    }
}
?>
