#!/usr/bin/sh

# modify bannerid to any real id before generating test raw data
ab -n5000 -c50 'http://localhost/dev/www/delivery/afr.php?what=bannerid:2'
ab -n5000 -c50 'http://localhost/dev/www/delivery/lg.php?bannerid=2'
ab -n5000 -c50 'http://localhost/dev/www/delivery/ck.php?oaparams=2__bannerid=10149__zoneid=0__cb=5ec806661f__maxdest=http://localhost'
