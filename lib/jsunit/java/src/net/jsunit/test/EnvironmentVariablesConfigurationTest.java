package net.jsunit.test;

import junit.framework.TestCase;
import net.jsunit.EnvironmentVariablesConfiguration;
import net.jsunit.Configuration;

public class EnvironmentVariablesConfigurationTest extends TestCase {
    private EnvironmentVariablesConfiguration config;

    protected void setUp() throws Exception {
        super.setUp();
        config = new EnvironmentVariablesConfiguration();
    }

    public void testSimple() {
        System.setProperty(Configuration.BROWSER_FILE_NAMES, "aaa");
        System.setProperty(Configuration.LOGS_DIRECTORY, "bbb");
        System.setProperty(Configuration.PORT, "1234");
        System.setProperty(Configuration.RESOURCE_BASE, "ccc");
        System.setProperty(Configuration.URL, "ddd");
        assertTrue(config.isAppropriate());
        assertEquals("aaa", config.browserFileNames());
        assertEquals("bbb", config.logsDirectory());
        assertEquals("1234", config.port());
        assertEquals("ccc", config.resourceBase());
        assertEquals("ddd", config.url());
    }

    public void testIsAppropriate() {
        assertFalse(config.isAppropriate());
    }

    public void tearDown() throws Exception {
        System.getProperties().remove(Configuration.BROWSER_FILE_NAMES);
        System.getProperties().remove(Configuration.LOGS_DIRECTORY);
        System.getProperties().remove(Configuration.PORT);
        System.getProperties().remove(Configuration.RESOURCE_BASE);
        System.getProperties().remove(Configuration.URL);
        super.tearDown();
    }

}