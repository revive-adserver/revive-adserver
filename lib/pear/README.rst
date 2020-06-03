*************************
PEAR - The PEAR Installer
*************************
.. image:: https://travis-ci.org/pear/pear-core.svg?branch=stable
    :target: https://travis-ci.org/pear/pear-core

=========================================
What is the PEAR Installer? What is PEAR?
=========================================
PEAR is the PHP Extension and Application Repository, found at
http://pear.php.net.

The **PEAR Installer** is this software, which contains executable
files and PHP code that is used to **download and install** PEAR code
from pear.php.net.

PEAR contains useful **software libraries and applications** such as
MDB2 (database abstraction), HTML_QuickForm (HTML forms management),
PhpDocumentor (auto-documentation generator), DB_DataObject
(Data Access Abstraction), and many hundreds more.
Browse all available packages at http://pear.php.net, the list is
constantly growing and updating to reflect improvements in the PHP language.

.. warning::
  Do not run PEAR without installing it - if you downloaded this
  tarball manually, you MUST install it.  Read the instructions in INSTALL
  prior to use.


=============
Documentation
=============
Documentation for PEAR can be found at http://pear.php.net/manual/.
Installation documentation can be found in the INSTALL file included
in this tarball.


=====
Tests
=====
Run the tests without installation as follows::

  $ ./scripts/pear.sh run-tests -r tests

You should have the ``Text_Diff`` package installed to get nicer error output.

To run the tests with another PHP version, modify ``php_bin`` and set the
``PHP_PEAR_PHP_BIN`` environment variable::

  $ pear config-set php_bin /usr/local/bin/php7
  $ PHP_PEAR_PHP_BIN=/usr/local/bin/php7 ./scripts/pear.sh run-tests -r tests

Happy PHPing, we hope PEAR will be a great tool for your development work!


Test dependencies
=================
* ``zlib``


=========
Releasing
=========
Create a PEAR package as well as phars for pear-less installation::

    $ rm -f PEAR-*.tgz
    $ pear package package2.xml
    $ cd go-pear-tarballs
    $ rm -f PEAR-*
    $ cp ../PEAR-*.tgz .
    $ gunzip PEAR-*.tgz
    $ pear download -Z Archive_Tar Console_Getopt Structures_Graph XML_Util
    $ mkdir src && cd src
    $ for i in ../*.tar; do tar xvf $i; done
    $ mv *\/* .
    $ cd ../../
    $ php make-gopear-phar.php
    $ php make-installpear-nozlib-phar.php

(Or simply run ``build-release.sh``).

``go-pear.phar`` is contains the PEAR installer installer that asks questions
where to install it.
It is available from http://pear.php.net/go-pear.phar.

``install-pear-nozlib.phar`` installs PEAR automatically without asking
anything.
It is shipped with PHP itself.
