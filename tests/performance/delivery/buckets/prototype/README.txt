
== Prototypes ==

In order to check the behaviour of different types of logging a prototypes were created which can be used
for testing a performance of log script (lg.php).

Scripts are using "runkit" module to avoid code repetition.

List of prototypes:
* db_prototype - uses buckets and updates each of buckets on each request

== Requirements ==

The script requires:
* "runkit" pecl module: http://pecl.php.net/package/runkit
* PHP5
* MySQL (or PostgreSQL)

Runkit documentation:
http://uk2.php.net/runkit

== Installation ==

* Install runkit, see section: Runkit Installation
* Install openx (only mysql and postgresql are supported)
* Configure OpenX to use prototype, see section: Configuration
* Create buckets, see section: parameters
* Run tests, see section: Performance tests

== Runkit Installation ==

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
type=../../../../tests/performance/delivery/buckets/prototype/db_prototype

If the type is not set it is possible to do a compare tests (see "Performance tests") by running
OpenX logging once with custom prototype and another time with default raw impressions logging.

== Parameters ==

List of parameters (can be use to drop and create buckets and to customize logging data into buckets):
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
* buckets - (TODO - not fully implemented yet, default buckets are used)
           comma separated list of buckets to create or to log data into while in logging only mode,
           default=data_bucket_impression,data_bucket_impression_country,data_bucket_frequency
* rand - maximum number of random zone to choose from, eg if rand = 1000 the logging will be done
           for random 1-1000 ads and zones mt_rand(1,rand). This is to help randomize the distribution
           of records in buckets so the tests will be more reliable.
           default=1000

To create all buckets before running the performance tests use the GET parameter "createBuckets",
for example following URL creates default buckets for update logging and drop old buckets table, if any exists:
http://localhost/openx/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1&createBuckets=1&dropBuckets=1&logMethod=update


== Performance tests ==

Make sure to create buckets first by doing a separate request to lg.php before executing the performance tests

You may use apache ab to do performance tests of created prototypes.

Sample command:
# ab -n1000 -c50 'http://localhost/openx/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1'


== Optimization ==

* https://developer.openx.org/wiki/display/COMM/Delivery+Optimization