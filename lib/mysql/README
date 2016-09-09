mysql methods using PDO
===============================
This package can be used to access MySQL databases using PDO wrapper functions. It provides a class with functions that can access a MySQL database in a way that is compatible with the original MySQL extension. The package provides global mysql_* functions that can be used when the original MySQL extension is not available with PDO as a backend.

The object duplicates all of the functionality of mysql_* functions except for mysql_info method which I tried to duplicate as best as I can, but due to PDO limitations/my knowledge I can’t do it exact.

Implementation:
---------------
In your bootstrap, include:

    // Include the definitions
    require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'MySQL_Definitions.php');
     
    // Include the object
    require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'MySQL.php');
     
    // Include the mysql_* functions
    require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'MySQL_Functions.php');
     
    // Now all of the mysql_* methods will work on a PHP version that has them removed.

(OPTIONAL : SEE DRAWBACKS) Update your error reporting to (depending on environment):

    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT); // Production
    error_reporting(E_ALL & ~E_STRICT); // Development

(OPTIONAL : SEE DRAWBACKS) If you are using is_resource / get_resource_type for mysql_ methods you will need to replace them with the following functions: is_resource_custom / get_resource_type_custom. You can use your IDE to search replace or the following two lines in your project base:


    find ./ -type f | xargs sed -i 's/is_resource( /is_resource_custom(/'
    find ./ -type f | xargs sed -i 's/get_resource_type( /get_resource_type_custom(/'


Who is this for?
----------------
This package is for site owners/developers who want to upgrade their PHP version to a version that has the mysql_connect/mysql_* functions removed without having to re-write their entire codebase to replace those functions to PDO or MySQLI.

Why were the mysql extension removed?
-------------------------------------
Lack of:

* Stored Procedures (can’t handle multiple result sets)
* Prepared Statements
* Encryption (SSL)
* Compression
* Full Charset support
* Security

mysql_* methods are easy to understand, but hard to secure. Since it does not provide Prepared Statements, more developers (beginners in particular) are prone to security risks. Not that mysql_* methods are insecure, but it makes it easier for beginner coders to make insecure queries.

Alternative host:
-----------------
This project can also be found on phpclasses.org:
http://www.phpclasses.org/package/8221-PHP-Access-MySQL-databases-using-PDO-wrapper-functions.html

and GitHub:
https://github.com/AzizSaleh/mysql

I will try my best to keep them updated.

Drawbacks of this library
=========================
Unfortunately due to limitations, there are some things you should know before implementing this library.

Resources
---------
Since it is not possible to create resources on the fly in PHP. The following methods will not work as intended:

is_resource
get_resource_type

on the following mysql functions:

    Function Name (resource type) (our library type)
    mysql_connect (mysql link) (int)
    mysql_pconnect (mysql link persistent) (int)
    mysql_db_query (mysql result) (PDO Statement)
    mysql_list_dbs (mysql result) (PDO Statement)
    mysql_list_fields (mysql result) (PDO Statement)
    mysql_list_processors (mysql result) (PDO Statement)
    mysql_list_dbs (mysql result) (PDO Statement)
    mysql_query (mysql result) (PDO Statement)
    mysql_unbuffered_query (mysql result) (PDO Statement)

To fix, you you will need to replace them with the following functions: is_resource_custom / get_resource_type_custom. You can use your IDE to search replace or the following two lines in your project base:

    find ./ -type f | xargs sed -i 's/is_resource( /is_resource_custom(/'
    find ./ -type f | xargs sed -i 's/get_resource_type( /get_resource_type_custom(/'

Error Reporting
---------------
If you pass a constant to the following methods (ex: string), you will  trigger the following error "PHP Strict Standards:  Only variables should be passed by reference" in PHP strict error mode (errro_reporting(>= 30720)):

    mysql_fetch_array
    mysql_fetch_assoc
    mysql_fetch_row
    mysql_fetch_object
    mysql_db_name
    mysql_dbname
    mysql_tablename
    mysql_result
    mysql_free_result
    mysql_freeresult
    mysql_field_len
    mysql_fieldlen
    mysql_field_flags
    mysql_fieldflags
    mysql_field_name
    mysql_fieldname
    mysql_field_type
    mysql_fieldtype
    mysql_field_table
    mysql_fieldtable
    mysql_field_seek
    mysql_fetch_field

To fix, you will need to change your error reporting hide strict standards (anything <= 30719). Examples:

    error_reporting(30719); // <= 30719
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT); // Production
    error_reporting(E_ALL & ~E_STRICT); // Development

Unit Testing
-------------

There are 2 unit tests available in this project:

* MySQL_Test.php - Run this test is you are using PHP with mysql_connect() enabled.
* MySQL_Test_After.php - Run this test if the PHP version you have does not have mysql_connect() enabled.


About:
------
If you run into any issues, bugs, features or make things better please send them to me and I will get them in as soon as I can.

    @author    Aziz S. Hussain <azizsaleh@gmail.com>
    @copyright GPL license 
    @license   http://www.gnu.org/copyleft/gpl.html 
    @link      http://www.AzizSaleh.com

Versions:
=========

Current Version
---------------
Version 1.1

Version History:
----------------
1.0 - September 2013
* Initial release.
* Tested via unit testing on PHP 5.0

1.1 - February 2014
* Initial Github release.
* Sever Bugs reported by Domenic LaRosa fixed.
* Tested on PHP 5.5.59
* Added is_resource_custom/get_resource_type_custom functions.
* Added unit test for PHP >= 5.5.5
* Fixed some logical issues not tested on PHP >= 5.5.5

1.2 - September 2014
 * Fixed an issue (Thanks to Martijn Spruit) where the script was breaking on PHP V <= 5.3.8
 * Updated unit test for MySQL_Stat_Test to allow a <= 10 difference between the numbers.