package net.jsunit.test;

import junit.framework.TestCase;
import net.jsunit.Configuration;
import net.jsunit.JsUnitServer;
import net.jsunit.PropertiesFileConfiguration;
import net.jsunit.Utility;

public class PropertiesConfigurationTest extends TestCase {

    public void testNoFile() throws Exception {
        PropertiesFileConfiguration configuration = new PropertiesFileConfiguration("nosuch.file");
        try {
            configuration.configure(new JsUnitServer());
            fail("Should have through a Runtime because no properties file exists");
        } catch (RuntimeException e) {
        }
    }

    public void testSimple() throws Exception {
        writePropertiesFile("temp.file");
        PropertiesFileConfiguration configuration = new PropertiesFileConfiguration("temp.file");
        configuration.initialize();
        assertEquals("aaa", configuration.browserFileNames());
        assertEquals("bbb", configuration.logsDirectory());
        assertEquals("1234", configuration.port());
        assertEquals("ccc", configuration.resourceBase());
        assertEquals("ddd", configuration.url());
    }

    public void tearDown() throws Exception {
        Utility.deleteFile("temp.file");
//        Utility.deleteDirectory("bbb");
        super.tearDown();
    }

    private void writePropertiesFile(String fileName) {
        String contents =
                Configuration.BROWSER_FILE_NAMES + "=aaa\n" +
                Configuration.LOGS_DIRECTORY + "=bbb\n" +
                Configuration.PORT + "=1234\n" +
                Configuration.RESOURCE_BASE + "=ccc\n" +
                Configuration.URL + "=ddd";
        Utility.writeFile(contents, fileName);
    }

}