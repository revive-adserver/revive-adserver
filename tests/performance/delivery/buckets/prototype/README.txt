
== Prototypes ==

In order to check the behaviour of different types of logging a prototypes were created which can be used
for testing a performance of log script (lg.php).

Scripts are using "runkit" module to avoid code repetition.

List of prototypes:
* protos_mysql - uses buckets and updates each of buckets on each request


To create all buckets before running the performance tests use the GET parameter "createBuckets", for example:
http://localhost/openx/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1&createBuckets=1

List of parameters (use to drop and create buckets and to log data into buckets):
* createBuckets - creates required buckets (if they don't exist already)
* dropBuckets - Use together with createBuckets, drops buckets tables before
                new buckets are created (check if bucket exist before dropping it)
* engine - engine type used to create MySQL tables, ignored if a database type is not mysql.
           There is no need to set database type, the prototype reads the db type from
           OpenX configuration file
           default=memory
* logMethod - indicates which method should be used to log new records. Possible values: "update" or "insert"
           When used together with "createBuckets" the buckets for logMethod="insert" are created
           without primary keys so buckets may be used safely for inserts.
           default=update
* buckets - (TODO - not implemented yet)
           comma separated list of buckets to create or to log data into while in logging only mode,
           default=data_bucket_impression,data_bucket_impression_country,data_bucket_frequency
* rand - maximum number of random zone to choose from, eg if rand = 1000 the logging will be done
           for random 1-1000 ads and zones mt_rand(1,rand). This is to help randomize the distribution
           of records in buckets so the tests will be more reliable.
           default=1000

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
(see troubleshooting section if you experienced any problems)

add runkit.so to your php.ini file:
extension=runkit.so

Restart apache and check "runkit" secion in your phpinfo()


== Troubleshooting ==

* If you get error on line 230 while building this module:
  http://sobolewscy.in5.pl/piotr/blog/show.php?f=1171433695
    Edit file runkit_import.c line 230, add "strlen(key)" parameter:
    zend_unmangle_property_name(key, strlen(key), &cname, &pname);
* It seems that runkit do not recognize any upper cased (or camel cased)
  function names. Instead a "smallcased" names should be used in runkit
  functions parameters.


== Configuration ==

To use a prototype module edit your var/{host}.conf.php file and set:
[origin]
type=../../../../tests/performance/delivery/buckets/prototype/{prototype}

{prototype} is a name of prototype file (for example: protos_mysql).

For a list of all prototypes see section "Prototypes"


== Performance tests ==

Make sure to create buckets first by doing a separate request to lg.php before executing the performance tests

You may use apache ab to do performance tests of created prototypes.

Sample command:
# ab -n1000 -c50 'http://localhost/openx/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1'


== Optimization ==

* https://developer.openx.org/wiki/display/COMM/Delivery+Optimization