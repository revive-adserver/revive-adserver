package net.jsunit.test;

import net.jsunit.ArgumentsConfiguration;
import net.jsunit.Utility;
import net.jsunit.JsUnitServer;

import java.io.File;
import java.util.Arrays;
import java.util.List;

import junit.framework.TestCase;

public class ArgumentsConfigurationTest extends TestCase {
    public ArgumentsConfigurationTest(String name) {
        super(name);
    }

    public void testSimple() throws Exception {
        List args = Arrays.asList(new String[] {
            "-port", "12345",
            "-url", "http://www.jsunit.net/",
            "-resourceBase", "foo",
            "-logsDirectory", "bar",
            "-remoteMachineNames", "foo,bar",
            "-browserFileNames", "fu,bar"
        });
        JsUnitServer server = new JsUnitServer();
        ArgumentsConfiguration configuration = new ArgumentsConfiguration(args);
        configuration.configure(server);
        assertEquals(12345, server.getPort());
        assertEquals(new File("foo"), server.getResourceBase());
        assertEquals(new File("bar"), server.getLogsDirectory());
        assertEquals(Utility.listWith("fu", "bar"), server.getLocalBrowserFileNames());
        assertEquals("http://www.jsunit.net/", server.getTestURL().toString());
    }

    public void tearDown() throws Exception {
        File createdLogsDirectory = new File("bar");
        if (createdLogsDirectory.exists())
            createdLogsDirectory.delete();
        super.tearDown();
    }

}