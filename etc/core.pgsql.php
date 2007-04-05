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
CREATE OR REPLACE FUNCTION DATE_FORMAT(timestamptz, text) RETURNS text AS $$
DECLARE
 f text;
 r text[][] = ARRAY[['%Y','YYYY'],['%m','MM'],['%d','DD'],['%H','HH24'],['%i','MI'],['%S','SS']];
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
CREATE OR REPLACE FUNCTION TO_DAYS(timestamptz) RETURNS int AS $$
BEGIN
 IF ($1 = NULL) THEN
  RETURN NULL;
 END IF;
 RETURN floor(UNIX_TIMESTAMP($1)/86400)::int;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION UNIX_TIMESTAMP(timestamptz) RETURNS int AS $$
BEGIN
 IF ($1 = NULL) THEN
  RETURN 0;
 END IF;
 RETURN date_part('epoch', $1)::int;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

?>