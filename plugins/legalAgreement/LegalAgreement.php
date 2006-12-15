<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * Plugins_LegalAgreement is an abstract class for every LegalAgreement plugin.
 *
 * @package    MaxPlugin
 * @subpackage LegalAgreement
 * @author     Matteo Beccati <matteo@beccati.com>
 * @abstract
 */
class Plugins_LegalAgreement extends MAX_Plugin_Common
{
    /**
     * Constructor
     */
    function Plugins_LegalAgreement()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $this->dbh = $oServiceLocator->get('MAX_DB');
        if (!$this->dbh) {
            $this->dbh = &MAX_DB::singleton();
        }
    }

    /**
     * A method to return the name of plugin
     *
     * @abstract
     * @return string
     */
    function getName()
    {
        Max::debug('Cannot run abstract method');
        exit();
    }

    /**
     * A method to return the LegalAgreement plugin hook type.
     *
     * @abstract
     * @return integer Either LEGALAGREEMENT_PLUGIN_PRE or LEGALAGREEMENT_PLUGIN_POST.
     */
    function getHookType()
    {
        Max::debug('Cannot run abstract method');
        exit();
    }

    /**
     * The main method to carry out the plugin's actions.
     *
     * @abstract
     * @param array $aParams An optional array of parameters. The parameters
     *                       passed in will be specific to the plugin hook
     *                       point the plugin is written for. See the API
     *                       tutorial on plugins.
     */
    function run($aParams = null)
    {
        Max::debug('Cannot run abstract method');
        exit();
    }

}

?>
