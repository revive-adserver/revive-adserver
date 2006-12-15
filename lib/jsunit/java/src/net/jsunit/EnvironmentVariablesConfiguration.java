package net.jsunit;

public class EnvironmentVariablesConfiguration extends Configuration {

    public String resourceBase() {
        return System.getProperty(RESOURCE_BASE);
    }

    public String port() {
        return System.getProperty(PORT);
    }

    public String logsDirectory() {
        return System.getProperty(LOGS_DIRECTORY);
    }

    public String browserFileNames() {
        return System.getProperty(BROWSER_FILE_NAMES);
    }

    public String url() {
        return System.getProperty(URL);
    }

    public boolean isAppropriate() {
        return url() != null;
    }
}
