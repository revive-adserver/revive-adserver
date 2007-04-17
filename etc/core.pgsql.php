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
$Id: Acls.dal.test.php 5552 2007-04-03 19:52:40Z andrew.hill@openads.org $
*/

/**
 * A file of custom PL/pgSQL function definitions required to ensure that
 * MySQL built in functions can be called and will work when using the
 * PostgreSQL database engine.
 */

$aCustomFunctions = array();

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION DATE_ADD(timestamptz, interval) RETURNS timestamptz AS $$
BEGIN
 RETURN $1 + $2;
END;
$$ LANGUAGE plpgsql IMMUTABLE STRICT;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION DATE_FORMAT(timestamptz, text) RETURNS text AS $$
DECLARE
 f text;
 r text[][] = ARRAY[['%Y','YYYY'],['%m','MM'],['%d','DD'],['%H','HH24'],['%i','MI'],['%S','SS'],['%k','FMHH24']];
 i int4;
BEGIN
 f := $2;
 FOR i IN 1..array_upper(r, 1) LOOP
   f := replace(f, r[i][1], r[i][2]);
 END LOOP;
 RETURN to_char($1, f);
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION FIND_IN_SET(integer, text) RETURNS integer AS $$
DECLARE
 a varchar[];
 i int4;
BEGIN
 IF LENGTH($2) > 0 THEN
   a := string_to_array($2, ',');
   FOR i IN 1..array_upper(a, 1) LOOP
     IF $1 = a[i] THEN
       RETURN i;
     END IF;
   END LOOP;
 END IF;
 RETURN 0;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION IF(boolean, integer, integer) RETURNS integer AS $$
BEGIN
 IF ($1) THEN
  RETURN $2;
 END IF;
 RETURN $3;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION IF(boolean, character varying, integer) RETURNS integer AS $$
BEGIN
 IF ($1) THEN
  RETURN $2;
 END IF;
 RETURN $3;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION IF(boolean, character varying, character varying) RETURNS character varying AS $$
BEGIN
 IF ($1) THEN
  RETURN $2;
 END IF;
 RETURN $3;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

// IFNULL is not STRICT as the $1 parameter may be NULL.
$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION IFNULL(numeric, integer) RETURNS integer AS $$
BEGIN
 IF ($1 IS NULL) THEN
  RETURN $2;
 END IF;
 RETURN $1::integer;
END;
$$ LANGUAGE plpgsql IMMUTABLE;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION TO_DAYS(timestamptz) RETURNS int4 AS $$
BEGIN
 RETURN round(date_part('epoch', $1::date) / 86400)::int4 + 719528;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION UNIX_TIMESTAMP(timestamptz) RETURNS int AS $$
BEGIN
 RETURN date_part('epoch', $1)::int;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

?>