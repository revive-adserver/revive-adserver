package net.jsunit;

import java.io.FileInputStream;
import java.util.Properties;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class PropertiesFileConfiguration extends Configuration {

    public static final String PROPERTIES_FILE_NAME = "jsunit.properties";

    private Properties properties;
    private String propertiesFileName;

    public PropertiesFileConfiguration(String propertiesFileName) {
        this.propertiesFileName = propertiesFileName;
    }

    public PropertiesFileConfiguration() {
        this(PROPERTIES_FILE_NAME);
    }

    public void initialize() {
        properties = new Properties();
        try {
            FileInputStream fileInputStream = new FileInputStream(propertiesFileName);
            properties.load(fileInputStream);
            fileInputStream.close();
        } catch (Exception e) {
            throw new RuntimeException("Could not load " + propertiesFileName);
        }
    }

    public String resourceBase() {
        return properties.getProperty(RESOURCE_BASE);
    }

    public String logsDirectory() {
        return properties.getProperty(LOGS_DIRECTORY);
    }

    public String port() {
        return properties.getProperty(PORT);
    }

    public String url() {
        return properties.getProperty(URL);
    }

    public String browserFileNames() {
        return properties.getProperty(BROWSER_FILE_NAMES);
    }

}