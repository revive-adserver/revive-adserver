"Delivery buckets" is the idea of storing aggregated tables in delivery and perform the aggregation process of impressions, clicks and conversions in delivery itself. Then those aggregated tables should be sent over to central server (or higher level aggregator servers).

These performance tests checks which of the ways is fastest for storing counters in deliveryand which method is better (in sql: inserts + summarization vs updates):
* in-memory mysql tables
* myisam and innodb mysql tables
* postgresql tables
* shared memory variables

File "buckets.php" tests most of above cases.

Requirements:
* databases: mysql and postgresql
* php modules: pcntl
* pear packages: Benchmark