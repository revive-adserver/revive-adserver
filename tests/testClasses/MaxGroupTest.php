<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id$
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
