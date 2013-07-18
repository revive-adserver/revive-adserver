+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+

The units in the changesfantasy folder comprise an entire *fictional* upgrade package, designed
to test upgrade possibilities of an up-to-date installation of OpenX.

The package may be used as a reference for building real-world upgrade packages.

To execute a fantasy upgrade:

[1] Your OpenX installation must be at the latest version already
[2] Copy var/UPGRADE to var/UPGRADE.FANTASY to trigger

To rollback the fantasy upgrade:

[1] With both var/UPGRADE and var/UPGRADE.FANTASY in place
[2] Rename var/RECOVER.FANTASY to var/RECOVER to trigger rollback

Fantasy upgrade and rollback artefacts:

[1] var/openads_fantasy_upgrade_999.999.999_*.log for results of changesets
[2] var/fantasy.log for results of scripts
[3] var/openads_fantasy_upgrade_999.999.999_*.log.rollback for results of rollbacks
