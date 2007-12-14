<?php

require_once MAX_PATH . '/lib/gacl/tests/acl_setup.php';


class acl_test extends UnitTestCase {

	var $acl_setup;
	var $gacl_api;

	function acl_test() {
		$this->UnitTestCase();

		$conf = $GLOBALS['_MAX']['CONF'];
	    $oMDB2Wrapper =& new MDB2Wrapper(OA_DB::singleton());
        $options = array(
	       'db'              => &$oMDB2Wrapper,
	       'db_table_prefix' => $conf['table']['prefix'] . 'gacl_',
        );
		$this->gacl_api = &new gacl_api($options);

		$this->acl_setup = &new acl_setup($this->gacl_api);
	}

	function setUp()
	{
	    $this->acl_setup->setUp();
	}

	function tearDown()
	{
	    $this->acl_setup->tearDown();
	}

	function test_check_luke_lounge() {
		$result = $this->gacl_api->acl_check('test_aco','access','test_human','luke','test_location','lounge');
		$message = 'Luke should have access to the Lounge';
		$this->assertEqual(TRUE, $result, $message);
	}

	function test_check_luke_engines() {
		$result = $this->gacl_api->acl_check('test_aco','access','test_human','luke','test_location','engines');
		$message = 'Luke shouldn\'t have access to the Engines';
		$this->assertEqual(FALSE, $result, $message);
	}

	function test_check_chewie_guns() {
		$result = $this->gacl_api->acl_check('test_aco','access','test_alien','chewie','test_location','guns');
		$message = 'Chewie should have access to the Guns';
		$this->assertEqual(TRUE, $result, $message);
	}

	function test_check_chewie_engines() {
		$result = $this->gacl_api->acl_check('test_aco','access','test_alien','chewie','test_location','engines');
		$message = 'Chewie shouldn\'t have access to the Engines';
		$this->assertEqual(FALSE, $result, $message);
	}

	function test_query_luke_lounge() {
		$result = $this->gacl_api->acl_query('test_aco','access','test_human','luke','test_location','lounge');
		$expected = array(
			'acl_id' => $this->acl_setup->acl[2],
			'return_value' => '',
			'allow' => TRUE
		);
		$message = 'Luke should have access to the Lounge';

		$this->assertEqual($expected, $result, $message);
	}
}

?>