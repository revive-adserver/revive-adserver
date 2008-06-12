
== Prototypes ==

In order to check the behaviour of different types of logging a prototypes were created which can be used
for testing a performance of log script (lg.php).

List of prototypes:
* db_prototype - uses mysql or postgres buckets, can update buckets on each request or insert new record
                 per each request

== Requirements ==

The script requires:
* PHP5
* MySQL (or PostgreSQL)

== Installation ==

* Install openx (only mysql and postgresql are supported)
* Configure OpenX to use prototype, see section: Configuration
* Turn off automaintenance (edit config file: [maintenance]autoMaintenance=) to avoid unnecessary errors
  make performance tests more reliable
* Create buckets, see section: parameters
* Run tests, see section: Performance tests

== Configuration ==

To use a prototype module edit your var/{host}.conf.php file and set:
[origin]
type=../../../../tests/performance/delivery/buckets/prototype/db_prototype

It is possible to do a comparison tests (see "Performance tests"). To do a comparison tests run
OpenX logging once with custom prototype and another time with default raw impressions logging.
To test against default logging simply leave type empty (or comment it out).

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
* buckets - comma separated list of buckets to create or to log data into while in logging only mode,
           default=data_bucket_impression,data_bucket_impression_country,data_bucket_frequency
* rand - maximum number of random zone to choose from, eg if rand = 1000 the logging will be done
           for random 1-1000 ads and zones mt_rand(1,rand). This is to help randomize the distribution
           of records in buckets so the tests will be more reliable.
           default=1000

To create all buckets before running the performance tests use the GET parameter "createBuckets".

Example:
Following URL creates default buckets for update logging and drop old buckets table:
http://localhost/openx/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1&createBuckets=1&dropBuckets=1&logMethod=update

== Performance tests ==

Make sure to create buckets first (see "parameters" section)
You may use apache ab to do performance tests of created prototypes.

Example:
Send 1000 requests, 50 concurrent:
# ab -n1000 -c50 'http://localhost/openx/trunk/www/delivery_dev/lg.php?bannerid=1&zoneid=1'

== Optimization ==
* https://developer.openx.org/wiki/display/COMM/Delivery+Optimization