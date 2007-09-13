<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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

class postscript_tables_core_999100
{
    var $oUpgrader;
    var $prefix;

    function postscript_tables_core_999100()
    {

    }

    function execute_constructive($aParams)
    {
        $this->oUpgrader = $aParams[0];
		return $this->insertData();
    }

    function execute_destructive($aParams)
    {
        return true;
    }

    function insertData()
    {
        for ($i=1;$i<10;$i++)
        {
            $query = "INSERT INTO "
                     .$this->oUpgrader->oDbh->quoteIdentifier($this->oUpgrader->oDBUpgrader->prefix.'astro',true).
                     " (
                        id_field,
                        desc_field
                        )
                       VALUES
                        (
                        {$i},
                        'desc {$i}'
                        )";
            $result = $this->oUpgrader->oDbh->exec($query);
            if (PEAR::isError($result))
            {
                $this->oUpgrader->oLogger->logOnly('insertData failed: '.$result->getUserInfo());
            }
        }
        $this->oUpgrader->oLogger->logOnly('insertData completed');
        return true;
    }

}

?>