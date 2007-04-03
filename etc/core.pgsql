CREATE OR REPLACE FUNCTION FIND_IN_SET(integer, text) RETURNS integer AS $_$
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
$_$ LANGUAGE plpgsql STRICT IMMUTABLE;