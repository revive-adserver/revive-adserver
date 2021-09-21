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
 * A class used to read the files from choosen directory which match
 * the specific criteria (ereg or just file extension). First version was
 * created as a university project (php loc counter).
 *
 * The idea of this class was taken from: http://sourceforge.net/projects/phpduploc
 *
 * @package    Max
 */
class MAX_FileScanner
{
    public $_files;
    public $_allowedFileMask;
    public $_allowedFileTypes;

    public $_lastMatch;
    public $_sorted;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_allowedFileTypes = [];
        $this->_allowedFileMask = null; // eg: '^([a-zA-Z0-9\-]*)\.plugin\.php$'
        $this->reset();
    }

    /**
     * Reset array of files
     *
     */
    public function reset()
    {
        $this->_files = [];
        $this->_lastMatch = null;
    }

    /**
     * Add specific file to the array of files
     *
     * @param string $file  File name
     *
     */
    public function addFile($file)
    {
        $this->_sorted = false;
        if ($this->isAllowedFile($file)) {
            if (!in_array($file, $this->_files)) {
                $key = $this->buildKey($file);
                if (empty($key)) {
                    $this->_files[] = $file;
                } else {
                    $this->_files[$key] = $file;
                }
            }
        }
    }

    /**
     * Read entire folder and add all the files
     *
     * @param string $dir                 Folder name
     * @param integer|boolean $recursive  If true add also subdirectories
     *                                    If integer - how deep, how many levels
     *
     */
    public function addDir($dir, $recursive = false)
    {
        if ($recursive) {
            return $this->_addRecursiveDir($dir, $recursive);
        }
        if ($handle = opendir($dir)) {
            while ($file = readdir($handle)) {
                if (is_dir($dir . '/' . $file)) {
                    continue;
                }
                $this->addFile($dir . '/' . $file);
            }
            closedir($handle);
        }
    }

    /**
     * Read recursively entire directory and subdirectories and add
     * every file to the pool of files.
     *
     * @param string $dir      Directory name
     * @param integer|boolean  How many subdirectories (levels) read, how deep
     *
     */
    public function _addRecursiveDir($dir, $recursive = true)
    {
        if ($recursive !== true) {
            if ($recursive < 0) {
                return;
            }
            $recursive--;
        }
        // Don't try and scan non-dirs :)
        if (!is_dir($dir)) {
            return;
        }
        if ($handle = opendir($dir)) {
            while ($file = readdir($handle)) {
                if (is_dir($dir . '/' . $file) && $file != '.' && $file != '..') {
                    $this->_addRecursiveDir($dir . '/' . $file, $recursive);
                    continue;
                }
                $this->addFile($dir . '/' . $file);
            }
            closedir($handle);
        }
    }

    /**
     * Return list of files
     *
     */
    public function getAllFiles()
    {
        if (!$this->_sorted) {
            $this->_sorted = true;
            if (!empty($this->_allowedFileMask)) {
                asort($this->_files, SORT_STRING);
            } else {
                sort($this->_files, SORT_STRING);
            }
        }
        return $this->_files;
    }

    /**
     * Set new file mask
     *
     * @param string $fileMask  New file mask
     *
     */
    public function setFileMask($fileMask)
    {
        $this->_allowedFileMask = $fileMask;
    }

    /**
     * Add possible file extensions to fileTypes array
     *
     * @param array $fileTypes  Array of new types
     *
     * @return boolean True if array of existings file types was modified else false
     */
    public function addFileTypes($fileTypes)
    {
        if (!is_array($fileTypes)) {
            $fileTypes = [$fileTypes];
        }
        $modified = false;
        if (is_array($fileTypes)) {
            foreach ($fileTypes as $fileType) {
                if (!in_array($fileType, $this->_allowedFileTypes)) {
                    $this->_allowedFileTypes[] = $fileType;
                    $modified = true;
                }
            }
        }
        return $modified;
    }

    /**
     * Check if a file is allowed. Check extension of file and if file matching the file mask
     *
     * @param string $fileName  File name
     *
     * @return boolean  True if file name match the criteria else false
     */
    public function isAllowedFile($fileName)
    {
        if (!empty($this->_allowedFileTypes)) {
            // Check extension
            $ext = $this->getFileExtension($fileName);
            // Check if uploaded file is of valid type
            if (!in_array(strtolower($ext), $this->_allowedFileTypes)) {
                return false;
            }
        }
        // Check if file name is allowed
        if (!empty($this->_allowedFileMask)) {
            $matches = null;
            if (!preg_match($this->_allowedFileMask, $fileName, $matches)) {
                return false;
            } else {
                $this->_lastMatch = $matches;
            }
        }
        return true;
    }

    /**
     * Return extension of file
     *
     * @param string $fileName  Name of the file
     *
     * @return string  File extension
     * @static
     */
    public function getFileExtension($fileName)
    {
        return substr($fileName, strrpos($fileName, '.') + 1, strlen($fileName));
    }

    /**
     * Return file name
     *
     * @param string $fileName  Name of the file
     *
     * @return string  File name
     * @static
     */
    public function getFileName($fileName)
    {
        return substr($fileName, strrpos($fileName, '/') + 1, strlen($fileName));
    }

    /**
     * Check if a file is allowed. Check extension of file and if file matching the file mask
     *
     * TODO: add configuration to this method - now building the key is hardcoded
     *
     * @param string $fileName  File name
     *
     * @return string  Key, this is package name and plugin name
     */
    public function buildKey($fileName)
    {
        if (empty($this->_allowedFileMask)) {
            return null;
        }
        if (!empty($this->_lastMatch)) {
            $matches = $this->_lastMatch;
        } else {
            $matches = null;
            preg_match($this->_allowedFileMask, $fileName, $matches);
        }
        if (is_array($matches) && count($matches) == 4) {
            $key = $matches[2] . ':' . $matches[3];
            return $key;
        }
        return null;
    }
}
