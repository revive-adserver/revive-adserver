<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once MAX_PATH . '/lib/gacl/gacl.class.php';
require_once MAX_PATH . '/lib/gacl/gacl_api.class.php';
require_once MAX_PATH . '/lib/gacl/MDB2Wrapper.php';


class OA_Permission_Gacl extends gacl_api
{
    function OA_Permission_Gacl($options = null)
    {
        if (is_null($options)) {
            $oMDB2Wrapper =& new MDB2Wrapper(OA_DB::singleton());
            $options = array(
               'db'              => &$oMDB2Wrapper,
               'db_table_prefix' => $GLOBALS['_MAX']['CONF']['table']['prefix'] . 'gacl_',
            );
        }
        parent::gacl_api($options);
    }

    /**
     * A (singleton) factory method to create a gacl_api instance
     *
     * @static
     *
     * @return OA_Permission_Gacl
     */
    function &factory()
    {
	    static $oGacl;
	    if (isset($oGacl)) {
	    	return $oGacl;
	    }
        $oGacl = &new OA_Permission_Gacl();
        return $oGacl;
    }
    
    /**
     * Sets debugging flag
     *
     * @param boolean $debug
     */
    function setDebug($debug)
    {
        $this->_debug = $debug;
    }
    
   /**
	* Prints debug text if debug is enabled.
	* 
	* @todo Refactor following method so it should
	*       log errors in error log and show errors when necessary
	*       using PEAR::raiseError($text);
	* 
	* @param string THe text to output
	* @return boolean Always returns true
	*/
	function debug_text($text) {
	    if ($this->_debug) {
			echo "$text<br>\n";
		}

		return true;
	}

}

?>
