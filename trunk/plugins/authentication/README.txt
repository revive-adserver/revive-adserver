== Authentication plugins ==

It is possible to write your own authentication plugin for Openads.
Two plugins were written - one which uses internal database to
authenticate users and other which uses cas protocol.

In order to change authentication plugin edit [authentication] section in configuration file
and change "type" value to one of the plugins names (currently "internal" or "cas").

For more information on each of the used method look into the each plugin class.