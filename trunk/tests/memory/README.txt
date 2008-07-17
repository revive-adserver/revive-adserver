== How to check memory footprint ==

In order to run a memory check add a "memory_append.php" script as a auto_append_file to php.ini.
It could be done either in .htaccess file or inside php.ini itself:
{{{
auto_append_file = /location/to/this/folder/memory_append.php
}}}

Following file analyze each OpenX file and create a tab separated file inside "var" folder: memory.log

There is no much use of memory footprint tests without any data stored in database. In order to
generate testing data please use provided "generate-data.php" script which generates as many records
as required. Bear in mind that provided script remove first the data stored in database 
(it doesn't recreate the scheme and it only deals with data).

Synopsis of use (generates 100 records using database with access properties stored inside localhost.con.php file):
# php generate-data.php localhost 100

(works only in PHP4.4 and newer)

