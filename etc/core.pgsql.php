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
 * A file of custom PL/pgSQL function definitions required to ensure that
 * MySQL built in functions can be called and will work when using the
 * PostgreSQL database engine.
 */

$aCustomFunctions = [];
$aBackupFunctions = [];

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION DATE_ADD(timestamptz, interval) RETURNS timestamptz AS $$
BEGIN
 RETURN $1 + $2;
END;
$$ LANGUAGE plpgsql IMMUTABLE STRICT;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION DATE_SUB(timestamptz, interval) RETURNS timestamptz AS $$
BEGIN
 RETURN $1 - $2;
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
CREATE OR REPLACE FUNCTION DAYOFWEEK(timestamptz) RETURNS integer AS $$
DECLARE
 i int4;
BEGIN
 i = date_part('dow', $1);
 RETURN i + 1;
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
     IF $1 = a[i]::integer THEN
       RETURN i;
     END IF;
   END LOOP;
 END IF;
 RETURN 0;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

// IF is not STRICT as the parameters may be NULL.
$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION IF(boolean, integer, integer) RETURNS integer AS $$
BEGIN
 IF ($1) THEN
  RETURN $2;
 END IF;
 RETURN $3;
END;
$$ LANGUAGE plpgsql IMMUTABLE;";

// IF is not STRICT as the parameters may be NULL.
$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION IF(boolean, character varying, integer) RETURNS integer AS $$
BEGIN
 IF ($1) THEN
  RETURN $2;
 END IF;
 RETURN $3;
END;
$$ LANGUAGE plpgsql IMMUTABLE;";

// IF is not STRICT as the parameters may be NULL.
$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION IF(boolean, character varying, character varying) RETURNS character varying AS $$
BEGIN
 IF ($1) THEN
  RETURN $2;
 END IF;
 RETURN $3;
END;
$$ LANGUAGE plpgsql IMMUTABLE;";

// IF is not STRICT as the parameters may be NULL.
$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION IF(boolean, timestamptz, timestamptz) RETURNS timestamptz AS $$
BEGIN
 IF ($1) THEN
  RETURN $2;
 END IF;
 RETURN $3;
END;
$$ LANGUAGE plpgsql IMMUTABLE;";

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
CREATE OR REPLACE FUNCTION HOUR(timestamptz) RETURNS integer AS $$
BEGIN
 RETURN date_part('hour', $1)::integer;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

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

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION CONCAT(text, text) RETURNS text AS $$
BEGIN
 RETURN $1 || $2;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

$aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION CONCAT(anyelement) RETURNS text AS $$
BEGIN
 RETURN $1::text;
END;
$$ LANGUAGE plpgsql STRICT IMMUTABLE;";

$aBackupFunctions[] = $aCustomFunctions[] = "
CREATE OR REPLACE FUNCTION oxp_backup_table_copy(tbl_new text, tbl_old text) RETURNS void AS $$
DECLARE
  r record;
  c text;
  t_old text;
  t_new text;
  s_old text;
  s_new text;
  q text;
BEGIN
  t_old := quote_ident(tbl_old);
  t_new := quote_ident(tbl_new);
  EXECUTE 'CREATE TABLE ' || t_new || ' (LIKE ' || t_old || ' INCLUDING DEFAULTS)';
  FOR r IN SELECT column_name, column_default FROM information_schema.columns WHERE table_schema = CURRENT_SCHEMA() AND table_name = tbl_old AND column_default LIKE 'nextval(%' LOOP
    s_old := quote_ident(substring(r.column_default from '^[^'']+''([^'']+)'''));
    c := r.column_name;
    IF LENGTH(tbl_new) + LENGTH(c) > 58 THEN
      IF LENGTH(c) < 29 THEN
        s_new := substring(tbl_new from 0 for 58 - LENGTH(c)) || '_' || c;
      ELSIF LENGTH(tbl_new) < 29 THEN
        s_new := tbl_new || '_' || substring(c from 0 for 58 - LENGTH(tbl_new));
      ELSE
        s_new := substring(tbl_new from 0 for 29) || '_' || substring(c from 0 for 29);
      END IF;
    ELSE
      s_new := tbl_new || '_' || c;
    END IF;
    s_new := quote_ident(s_new || '_seq');
    c := quote_ident(c);
    EXECUTE 'ALTER SEQUENCE ' || s_old || ' OWNED BY NONE';
    EXECUTE 'ALTER SEQUENCE ' || s_old || ' OWNED BY ' || t_old || '.' || c;
    EXECUTE 'CREATE SEQUENCE ' || s_new;
    EXECUTE 'SELECT setval(''' || s_new || ''', last_value) FROM ' || s_old;
    EXECUTE 'ALTER TABLE ' || t_new || ' ALTER ' || c || ' SET DEFAULT nextval(''' || s_new || ''')';
  END LOOP;
  EXECUTE 'INSERT INTO ' || t_new || ' SELECT * FROM ' || t_old;
END;
$$ LANGUAGE plpgsql STRICT;";
