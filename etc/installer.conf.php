;<?php exit; ?>
;*** DO NOT REMOVE THE LINE ABOVE ***
;------------------------------------------------------------------------------------------;
; Installer command line tool settings                                                     ;
;------------------------------------------------------------------------------------------;

[database]
type      = mysqli ; Either mysqli or pgsql
host      = localhost
name      = database_name
socket    = ; pls fill in w/ path to use unix socket instead of tcp
port      = 3306
username  = database_user
password  = database_password

[table]
prefix  = rv_
type    = INNODB ; Either MyISAM, or INNODB, for MySQL ONLY

[admin]
username  = admin
password  = secret
email     =
language  = en
timezone  = ; empty to autodetect

[paths]
admin      = localhost/www/admin
delivery   = localhost/www/delivery
images     = localhost/www/images
imageStore = ; path to the image directory, empty to autodetect
