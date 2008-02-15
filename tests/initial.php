<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//FR" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <style type="text/css">
    body
    {
        background-position: top left;
        margin: 10px 10px 10px 10px;
    }

    /* Fonts */

    body, table, td, select
    {
    	font-family: Verdana, Arial, Helvetica, sans-serif;
    	font-size: 11px;
    }
  </style>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>
  </head>
  <body>
    <h2>
    <?php
        require_once 'init.php';
        preg_match('/^(\d+\.\d+)/', OA_VERSION, $aMatches);
        echo MAX_PRODUCT_NAME . ' ' . $aMatches[1];
    ?>
    Testing Suite
    </h2>
    <p>
      In order to run tests, please copy the test.conf.php file in the
      <?php echo MAX_PRODUCT_NAME; ?> /etc directory into the
      <?php echo MAX_PRODUCT_NAME; ?> /var directory, and edit the file,
      so that it contains your database server details, and your webpath
      access details.
    </p>
    <p>
      Please also ensure that the web server user has permission to write
      to the <?php echo MAX_PRODUCT_NAME; ?> /var and
      <?php echo MAX_PRODUCT_NAME; ?> /var/plugins directories.
    </p>
    <p>
      You will also need to give your web server user permission to write
      to the <?php echo MAX_PRODUCT_NAME; ?> /tests/results directory if
      you want to run the visualisation
      tests.
    </p>
    <p>
      PEAR PHPUnit tests require that an appropriate version of
      <a href="http://phpunit.de/" target="_blank">PHPUnit</a> be installed
      (e.g. PHPUnit 3.0 for using with PHP5, or PHPUnit 1.3.2 for PHP4) using PEAR,
      and each test may require additional configuration to run. See the appropriate
      PEAR library directory inside the <?php echo MAX_PRODUCT_NAME; ?> install
      for details.
    </p>
    <p>
      The Pear 'tests' directories should be writeable.
    </p>
    <p>
      For Pear::MDB2 and Pear::MDB2_Schema you should do the following:
    </p>
    <p>
      Copy test_setup.php.dist to test_setup.php in the Pear tests directory.
    </p>
    <p>
      For Pear::MDB2_Schema you should do the following:
    </p>
    <p>
      Open the test_setup.php for editing and enter your database user details
      for each installed DBMS that you have and uncomment the appropriate "#$dbarray[] = " lines.
      Also uncomment the section that requires MDB2_Schema and sets up the test datase.
    </p>
  </body>
</html>