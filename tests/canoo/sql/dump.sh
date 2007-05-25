#!/bin/sh
#
# Dumps testing database
#
# Help: 
# --hex-blob - dumps data binary so image could be imported properly into the database
# see mysqldump manual: http://dev.mysql.com/doc/refman/5.0/en/mysqldump.html

/usr/local/mysql5/bin/mysqldump --compact --hex-blob -u root -p delivery > delivery.sql
