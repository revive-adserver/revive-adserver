
== Prototypes ==

In order to check the behaviour of different types of logging a prototypes were created which can be used
for testing a performance of log script (lg.php).

Scripts are using "runkit" module to avoid code repetition.

List of prototypes:
* proto_mysql_update - uses buckets and updates each of buckets on each request


To create all buckets before running the performance tests use
the GET parameter "createBuckets", eg:
http://localhost/openx/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1&createBuckets=1

List of parameters:
* createBuckets - creates required buckets (if they do not exists, do not drop existing buckets)
* dropBuckets - can be used together with createBuckets only, drops buckets tables before
                they are created and if they exist
* engine - engine type used to create MySQL tables, default = MEMORY
* buckets - comma separated list of buckets to create or to log data into while in logging only mode,
            default: data_bucket_impression,data_bucket_impression_country,data_bucket_frequency
* rand - maximum number of random zone to choose from, eg if rand = 1000 the logging will be done
         for random 1-1000 ads and zones mt_rand(1,rand). This is to help randomize the distribution
         of records in buckets so the tests will be more reliable.


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
* It seems that runkit do not recognize any upper cased (or camel cased)
  function names. Instead a "smallcased" names should be used in runkit
  functions parameters.


== Configuration ==

To use one of prototype modules edit your var/{host}.conf.php file and set:
[origin]
type=../../../../tests/performance/delivery/buckets/prototype/{prototype}

Where {prototype} is a name of prototype file (for example: proto_mysql_update).
For a list of all prototypes see section "Prototypes"



== Performance tests ==

You may use apache ab to do performance tests of created prototypes.

Sample command:
# ab -n1000 -c50 'http://localhost/openx/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1'



== Optimization ==

Check url: https://developer.openx.org/wiki/display/COMM/Delivery+Optimization