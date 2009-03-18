package org.openx.user;

import junit.framework.Test;
import junit.framework.TestSuite;

public class UserServiceTests {

	public static Test suite() {
		TestSuite suite = new TestSuite("Test for org.openx.user");
		//$JUnit-BEGIN$
		suite.addTestSuite(TestAuthUser.class);
		suite.addTestSuite(TestGetUserListByAccountId.class);
		suite.addTestSuite(TestGetUser.class);
		suite.addTestSuite(TestAddUser.class);
		suite.addTestSuite(TestModifyUser.class);
		suite.addTestSuite(TestDeleteUser.class);
		//$JUnit-END$
		return suite;
	}

}
