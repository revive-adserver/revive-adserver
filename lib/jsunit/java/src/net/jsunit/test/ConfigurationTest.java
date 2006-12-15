package net.jsunit.test;

import junit.framework.TestCase;
import net.jsunit.*;

public class ConfigurationTest extends TestCase {

    public void testResolveArgumentsConfiguration() {
        Configuration configuration = Configuration.resolve(new String[] {"foo"});
        assertTrue(configuration instanceof ArgumentsConfiguration);
    }

    public void testResolveEnvironmentVariablesConfiguration() {
        System.setProperty(Configuration.URL, "foo");
        Configuration configuration = Configuration.resolve(new String[] {});
        assertTrue(configuration instanceof EnvironmentVariablesConfiguration);
    }

    public void testResolvePropertiesConfiguration() {
        Configuration configuration = Configuration.resolve(new String[] {});
        assertTrue(configuration instanceof PropertiesFileConfiguration);
    }

    protected void tearDown() throws Exception {
        System.getProperties().clear();
        super.tearDown();
    }

}