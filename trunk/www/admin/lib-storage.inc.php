<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once 'DB/DataObject/Cast.php';

/*-------------------------------------------------------*/
/* Store a file on the webserver                         */
/*-------------------------------------------------------*/

function phpAds_ImageStore($type, $name, $buffer, $overwrite = false)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	$pref = $GLOBALS['_MAX']['PREF'];
	// Make name web friendly
	$name = basename($name);
	$name = strtolower($name);
	$name = str_replace(" ", "_", $name);
	$name = str_replace("'", "", $name);
	if ($type == 'web') {
		if ($conf['store']['mode'] == 'ftp') {
			// FTP mode
			$server = array();
			$server['host'] = $conf['store']['ftpHost'];
			$server['path'] = $conf['store']['ftpPath'];
			if (($server['path'] != "") && (substr($server['path'], 0, 1) == "/")) {
			    $server['path'] = substr($server['path'], 1);
			}
			$server['user'] = $conf['store']['ftpUsername'];
			$server['pass'] = $conf['store']['ftpPassword'];
			$server['passiv'] = !empty( $conf['store']['ftpPassive'] );
            $stored_url = phpAds_FTPStore($server, $name, $buffer, $overwrite);
		} else {
			// Local mode
			if ($overwrite == false) {
				$name = phpAds_LocalUniqueName($name);
			}
			// Write the file
			if ($fp = @fopen($conf['store']['webDir']."/".$name, 'wb')) {
				@fwrite($fp, $buffer);
				@fclose($fp);
				$stored_url = $name;
			}
		}
	}
	if ($type == 'sql') {

	    // Look for existing image.
	    $doImages = OA_Dal::staticGetDO('images', $name);
	    if ($doImages) {
   			$doImages->contents = DB_DataObject_Cast::blob($buffer);
	        if ($overwrite == false) {
                $name = $doImages->getUniqueFileNameForDuplication();
    			$doImages->filename = $name;
    			$doImages->insert();
    		} else {
    		    $doImages->filename = $name;
    			$doImages->update();
    		}
	    } else {
	        $doImages = OA_Dal::factoryDO('images');
    	    $doImages->filename = $name;
   			$doImages->contents = DB_DataObject_Cast::blob($buffer);
    		$doImages->insert();
	    }
	}
    $stored_url = $name;
	if (isset($stored_url) && $stored_url != '') {
		return $stored_url;
	} else {
		return false;
	}
}

/*-------------------------------------------------------*/
/* Duplicate a file on the webserver                     */
/*-------------------------------------------------------*/

function phpAds_ImageDuplicate ($type, $name)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	$pref = $GLOBALS['_MAX']['PREF'];
	// Strip existing path
	$name = basename($name);
	if ($type == 'web') {
		if ($conf['store']['mode'] == 'ftp') {
			// FTP mode
			$server = array();
			$server['host'] = $conf['store']['ftpHost'];
			$server['path'] = $conf['store']['ftpPath'];
			if (($server['path'] != "") && (substr($server['path'], 0, 1) == "/")) {
			    $server['path'] = substr($server['path'], 1);
			}
			$server['user'] = $conf['store']['ftpUsername'];
			$server['pass'] = $conf['store']['ftpPassword'];
			$server['passiv'] = !empty( $conf['store']['ftpPassive'] );
			$stored_url = phpAds_FTPDuplicate($server, $name);
		} else {
			// Local mode
			$duplicate = phpAds_LocalUniqueName($name);
			if (@copy($conf['store']['webDir']."/".$name, $conf['store']['webDir']."/".$duplicate)) {
				$stored_url = $duplicate;
			}
		}
	}
	if ($type == 'sql') {
		if ($buffer = phpAds_ImageRetrieve($type, $name)) {
			$stored_url = phpAds_ImageStore($type, $name, $buffer);
		}
	}
	if (isset($stored_url) && $stored_url != '') {
		return ($stored_url);
	} else {
		return false;
	}
}

/*-------------------------------------------------------*/
/* Retrieve a file on the webserver                      */
/*-------------------------------------------------------*/

function phpAds_ImageRetrieve($type, $name)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	// Strip existing path
	$name = basename($name);
	if ($type == 'web') {
		if ($conf['store']['mode'] == 'ftp') {
			// FTP mode
			$server = array();
			$server['host'] = $conf['store']['ftpHost'];
			$server['path'] = $conf['store']['ftpPath'];
			if (($server['path'] != "") && (substr($server['path'], 0, 1) == "/")) {
			    $server['path'] = substr($server['path'], 1);
			}
			$server['user'] = $conf['store']['ftpUsername'];
			$server['pass'] = $conf['store']['ftpPassword'];
			$server['passiv'] = !empty( $conf['store']['ftpPassive'] );
			$result = phpAds_FTPRetrieve($server, $name);
		} else {
            // Local mode
		    $result = '';
            if ($fp = @fopen($conf['store']['webDir']."/".$name, 'rb')) {
                while (!feof($fp)) {
                    $result .= @fread($fp, 8192);
                }
                @fclose($fp);
            }
		}
	}
	if ($type == 'sql') {
        if ($dbImages = OA_Dal::staticGetDO('images', 'filename', $name)) {
            $result = $dbImages->contents;
        }

	}
	if (!empty($result)) {
		return ($result);
	} else {
		return false;
	}
}

/*-------------------------------------------------------*/
/* Remove a file from the webserver                      */
/*-------------------------------------------------------*/

function phpAds_ImageDelete ($type, $name)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	if ($type == 'web') {
		if ($conf['store']['mode'] == 'ftp') {
			// FTP mode
			$server = array();
			$server['host'] = $conf['store']['ftpHost'];
			$server['path'] = $conf['store']['ftpPath'];
			if (($server['path'] != "") && (substr($server['path'], 0, 1) == "/")) {
			    $server['path'] = substr($server['path'], 1);
			}
			$server['user'] = $conf['store']['ftpUsername'];
			$server['pass'] = $conf['store']['ftpPassword'];
			$server['passiv'] = !empty( $conf['store']['ftpPassive'] );
			phpAds_FTPDelete($server, $name);
		} else {
			if (@file_exists($conf['store']['webDir']."/".$name)) {
				@unlink($conf['store']['webDir']."/".$name);
			}
		}
	}
	if ($type == 'sql') {
        $doImages = OA_Dal::staticGetDO('images', 'filename', $name);
        $doImages->delete();
	}
}

/*-------------------------------------------------------*/
/* Get size of the file                                  */
/*-------------------------------------------------------*/

function phpAds_ImageSize ($type, $name)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	// Strip existing path
	$name = basename($name);
	if ($type == 'web') {
		if ($conf['store']['mode'] == 'ftp') {
			// FTP mode
			$server = array();
			$server['host'] = $conf['store']['ftpHost'];
			$server['path'] = $conf['store']['ftpPath'];
			if (($server['path'] != "") && (substr($server['path'], 0, 1) == "/")) {
			    $server['path'] = substr($server['path'], 1);
			}
			$server['user'] = $conf['store']['ftpUsername'];
			$server['pass'] = $conf['store']['ftpPassword'];
			$server['passiv'] = !empty( $conf['store']['ftpPassive'] );
			$result = phpAds_FTPSize($server, $name);
		} else {
			// Local mode
			$result = @filesize($conf['store']['webDir']."/".$name);
		}
	}
	if ($type == 'sql') {
        if ($doImages = OA_Dal::staticGetDO('images', 'filename', $name)) {
            $result = strlen($doImages->contents);
        }
	}
	if (isset($result) && $result != '') {
		return ($result);
	} else {
		return false;
	}
}


/*-------------------------------------------------------*/
/* Local storage functions                               */
/*-------------------------------------------------------*/

function phpAds_LocalUniqueName($name)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	$extension = substr($name, strrpos($name, ".") + 1);
	$base	   = substr($name, 0, strrpos($name, "."));
	if (@file_exists($conf['store']['webDir']."/".$base.".".$extension) == false) {
		return ($base.".".$extension);
	} else {
		if (eregi("^(.*)_([0-9]+)$", $base, $matches)) {
			$base = $matches[1];
			$i = $matches[2];
		} else {
			$i = 1;
		}
		$found = false;
		while ($found == false) {
			$i++;
			if (@file_exists($conf['store']['webDir']."/".$base."_".$i.".".$extension) == false) {
				$found = true;
			}
		}
		return ($base."_".$i.".".$extension);
	}
}

/*-------------------------------------------------------*/
/* FTP module storage function                           */
/*-------------------------------------------------------*/

function phpAds_FTPStore($server, $name, $buffer, $overwrite = false)
{
	$pref = $GLOBALS['_MAX']['PREF'];
	$conn_id = @ftp_connect($server['host']);
	if ($server['pass'] && $server['user']) {
		$login = @ftp_login($conn_id, $server['user'], $server['pass']);
	} else {
		$login = @ftp_login($conn_id, "anonymous", $pref['admin_email']);
	}
	if( $server['passiv'] ) {
		ftp_pasv( $conn_id, true );
	}
	if (($conn_id) || ($login)) {
		if ($overwrite == false) {
			$name = phpAds_FTPUniqueName($conn_id, $server['path'], $name);
		}
		// Change path
		if ($server['path'] != "") {
		    @ftp_chdir($conn_id, $server['path']);
		}
		// Create temporary file
		$tempfile = @tmpfile();
		@fwrite($tempfile, $buffer);
		@rewind($tempfile);
		// Upload the temporary file
		if (@ftp_fput($conn_id, $name, $tempfile, FTP_BINARY)) {
			$stored_url = $name;
		}
        //  chmod file so that it's world readable
        if(function_exists(ftp_chmod) && !@ftp_chmod($conn_id, 0644, $name)) {
            OA::debug('Unable to modify FTP permissions for file: '. $server['path'] .'/'. $name, PEAR_LOG_INFO);
        }
		@fclose($tempfile);
		@ftp_quit($conn_id);
	}
	if (isset($stored_url)) {
	    return ($stored_url);
	}
}


function phpAds_FTPDuplicate($server, $name)
{
	$pref = $GLOBALS['_MAX']['PREF'];
	$conn_id = @ftp_connect($server['host']);
	if ($server['pass'] && $server['user']) {
		$login = @ftp_login($conn_id, $server['user'], $server['pass']);
	} else {
		$login = @ftp_login($conn_id, "anonymous", $pref['admin_email']);
	}
	if( $server['passiv'] ) {
		ftp_pasv( $conn_id, true );
	}
	if (($conn_id) || ($login)) {
		if ($server['path'] != "") {
		    @ftp_chdir($conn_id, $server['path']);
		}
		// Create temporary file
		$tempfile = @tmpfile();
		// Download file to the temporary file
		if (@ftp_fget($conn_id, $tempfile, $name, FTP_BINARY)) {
			// Go to the beginning of the temporary file
			@rewind ($tempfile);
			// Upload temporary file
			$name = phpAds_FTPUniqueName($conn_id, $server['path'], $name);
			if (@ftp_fput ($conn_id, $name, $tempfile, FTP_BINARY)) {
				$stored_url = $name;
			}
            //  chmod file so that it's world readable
            if (function_exists('ftp_chmod') && !@ftp_chmod($conn_id, 0644, $name)) {
                OA::debug('Unable to modify FTP permissions for file: '. $server['path'] .'/'. $name, PEAR_LOG_INFO);
            }
		}
		@fclose($tempfile);
		@ftp_quit($conn_id);
	}
	if (isset($stored_url)) {
	    return ($stored_url);
	}
}


function phpAds_FTPRetrieve($server, $name)
{
	$pref = $GLOBALS['_MAX']['PREF'];
	$conn_id = @ftp_connect($server['host']);
	if ($server['pass'] && $server['user']) {
		$login = @ftp_login($conn_id, $server['user'], $server['pass']);
	} else {
		$login = @ftp_login($conn_id, "anonymous", $pref['admin_email']);
	}
	if( $server['passiv'] ) {
		ftp_pasv( $conn_id, true );
	}
	if (($conn_id) || ($login)) {
		if ($server['path'] != "") {
		    @ftp_chdir($conn_id, $server['path']);
		}
		// Create temporary file
		$tempfile = @tmpfile();
		// Download file to the temporary file
		if (@ftp_fget($conn_id, $tempfile, $name, FTP_BINARY)) {
			// Go to the beginning of the temporary file
			$size = @ftell($tempfile);
			@rewind($tempfile);
			$result = '';
            while (!feof($tempfile)) {
                $result .= fread($tempfile, 8192);
            }
            fclose($tempfile);
		}
		@fclose($tempfile);
		@ftp_quit($conn_id);
	}
	if (isset($result)) return ($result);
}

function phpAds_FTPDelete($server, $name)
{
	$pref = $GLOBALS['_MAX']['PREF'];
	$conn_id = @ftp_connect($server['host']);
	if ($server['pass'] && $server['user']) {
		$login = @ftp_login($conn_id, $server['user'], $server['pass']);
	} else {
		$login = @ftp_login($conn_id, "anonymous", $pref['admin_email']);
	}
	if( $server['passiv'] ) {
		ftp_pasv( $conn_id, true );
	}
	if (($conn_id) || ($login)) {
		if ($server['path'] != "") {
		    @ftp_chdir($conn_id, $server['path']);
		}
		if (@ftp_size($conn_id, $name) > 0) {
			@ftp_delete($conn_id, $name);
		}
		@ftp_quit($conn_id);
	}
}

function phpAds_FTPSize($server, $name)
{
	$pref = $GLOBALS['_MAX']['PREF'];
	$conn_id = @ftp_connect($server['host']);
	if ($server['pass'] && $server['user']) {
		$login = @ftp_login($conn_id, $server['user'], $server['pass']);
	} else {
		$login = @ftp_login($conn_id, "anonymous", $pref['admin_email']);
	}
	if( $server['passiv'] ) {
		ftp_pasv( $conn_id, true );
	}
	if (($conn_id) || ($login)) {
		if ($server['path'] != "") {
		    @ftp_chdir($conn_id, $server['path']);
		}
		$result = @ftp_size($conn_id, $name);
		@ftp_quit($conn_id);
	}
	if (isset($result)) {
	    return ($result);
	}
}

function phpAds_FTPUniqueName($conn_id, $path, $name)
{
	if ($path != "") {
		if (substr($path, 0, 1) == "/") {
		    $path = substr($path, 1);
		}
		@ftp_chdir($conn_id, $path);
	}
	$extension = substr($name, strrpos($name, ".") + 1);
	$base	   = substr($name, 0, strrpos($name, "."));
	if (@ftp_size($conn_id, $base.".".$extension) < 1) {
		return ($base.".".$extension);
	} else {
		if (eregi("^(.*)_([0-9]+)$", $base, $matches)) {
			$base = $matches[1];
			$i = $matches[2];
		} else {
			$i = 1;
		}
		$found = false;
		while ($found == false) {
			$i++;
			if (@ftp_size($conn_id, $base."_".$i.".".$extension) < 1) {
				$found = true;
			}
		}
		return ($base."_".$i.".".$extension);
	}
}

?>
