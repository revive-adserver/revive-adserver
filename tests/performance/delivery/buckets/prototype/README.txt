
== Prototypes ==

In order to check the behaviour of different types of logging a prototypes were created which can be used
for testing a performance of log script (lg.php).

Scripts are using "runkit" module to avoid code repetition.

List of prototypes:
* proto_mysql_update - uses buckets and updates each of them on each request



== Requirements ==

The script requires "runkit" pecl module:
http://pecl.php.net/package/runkit

Documentation:
http://uk2.php.net/runkit



== Installation ==

To install runkit pecl module:
# pecl install runkit

Or manually:
# wget http://pecl.php.net/get/runkit-0.9.tgz
# tar -zxf runkit-0.9.tgz
# cd runkit-0.9
# phpize
# ./configure
# make
# make install

then add runkit.so to your php.ini file:
extension=runkit.so

Restart apache and check "runkit" secion in your phpinfo()



== Troubleshooting ==

* If you get error on line 230 while building this module:
  http://sobolewscy.in5.pl/piotr/blog/show.php?f=1171433695
    Edit file runkit_import.c line 230, add "strlen(key)" parametere:
    zend_unmangle_property_name(key, strlen(key), &cname, &pname);



== Configuration ==

To use one of prototype modules edit your var/{host}.conf.php file and set:
[origin]
type=../../../../tests/performance/delivery/buckets/prototype/{prototype}

Where {prototype} is a name of prototype file (for example: proto_mysql_update).
For a list of all prototypes see section "Prototypes"



== Performance tests ==

You may use apache ab to do performance tests of created prototypes.

Sample command:
# ab -n1000 -c50 'http://localhost/openads/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1'



== Optimization ==

Check url: https://developer.openx.org/wiki/display/COMM/Delivery+Optimization