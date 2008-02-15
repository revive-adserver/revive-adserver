/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
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

The units in the changesfantasy folder comprise an entire *fictional* upgrade package, designed
to test upgrade possibilities of an up-to-date installation of OpenX.

The package may be used as a reference for building real-world upgrade packages.

To execete a fantasy upgrade:

[1] Your OpenX installation must be at the latest version already
[2] Copy var/UPGRADE to var/UPGRADE.FANTASY to trigger

To rollback the fantasy upgrade:

[1] With both var/UPGRADE and var/UPGRADE.FANTASY in place
[2] Rename var/RECOVER.FANTASY to var/RECOVER to trigger rollback

Fantasy upgrade and rollback artefacts:

[1] var/openads_fantasy_upgrade_999.999.999_*.log for results of changesets
[2] var/fantasy.log for results of scripts
[3] var/openads_fantasy_upgrade_999.999.999_*.log.rollback for results of rollbacks
