;<?php exit; ?>
;*** DO NOT REMOVE THE LINE ABOVE ***
[thorium]
production=0
sessionClustering=0
webtestAccountId=1
version=trunk

[database]
type=mysql
host=localhost
socket=
port=3306
username=root
password=
name=toe
protocol=tcp

[sso]
protocol=http
host=localhost
port=8080
path=/sso/login
clientPath=/sso
signup=/account/signup
forgot=/account/forgotPassword
emailFrom=publisher-services@openx.org
partialAccountUrl=http://localhost/oxh/www/admin/sso-accounts.php

[xmlrpc]
protocol=http
host=localhost
port=8080
path=/oxc/internal_xmlrpc