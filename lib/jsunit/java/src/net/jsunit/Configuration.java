package net.jsunit;

import java.io.File;
import java.net.URL;
import java.util.Arrays;
import java.util.List;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public abstract class Configuration {

    public static final String PORT = "port";
    public static final String RESOURCE_BASE = "resourceBase";
    public static final String LOGS_DIRECTORY = "logsDirectory";
    public static final String URL = "url";
    public static final String BROWSER_FILE_NAMES = "browserFileNames";

    public static final int DEFAULT_PORT = 8080;
    public static final String DEFAULT_RESOURCE_BASE = ".";

    public static Configuration resolve(String[] args) {
        if (args.length > 0)
            return new ArgumentsConfiguration(Arrays.asList(args));
        else {
            EnvironmentVariablesConfiguration evConfig = new EnvironmentVariablesConfiguration();
            if (evConfig.isAppropriate())
                return evConfig;
            return new PropertiesFileConfiguration();
        }
    }

    public void configure(JsUnitServer server) throws ConfigurationException {
        initialize();
        configureResourceBase(server);
        configurePort(server);
        configureLogsDirectory(server);
        configureBrowserFileNames(server);
        configureTestURL(server);
    }

    public void initialize() {
    }

    private void configureTestURL(JsUnitServer server) throws ConfigurationException {
        String urlString = url();
        try {
            server.setTestURL(new URL(urlString));
        } catch (Exception e) {
            throw new ConfigurationException(URL, urlString, e);
        }
    }

    private void configureBrowserFileNames(JsUnitServer server) throws ConfigurationException {
        String browserFileNamesString = browserFileNames();
        try {
            List browserFileNames = Utility.listFromCommaDelimitedString(browserFileNamesString);
            server.setLocalBrowserFileNames(browserFileNames);
        } catch (Exception e) {
            throw new ConfigurationException(BROWSER_FILE_NAMES, browserFileNamesString, e);
        }
    }

    private void configureLogsDirectory(JsUnitServer server) throws ConfigurationException {
        String logsDirectoryString = logsDirectory();
        try {
            if (Utility.isEmpty(logsDirectoryString))
                logsDirectoryString = resourceBaseCheckForDefault() + File.separator + "logs";
            File logsDirectory = new File(logsDirectoryString);
            if (!logsDirectory.exists()) {
                Utility.log("Creating logs directory " + logsDirectory, false);
                logsDirectory.mkdir();
            }
            server.setLogsDirectory(logsDirectory);
        } catch (Exception e) {
            throw new ConfigurationException(LOGS_DIRECTORY, logsDirectoryString, e);
        }
    }

    private void configurePort(JsUnitServer server) throws ConfigurationException {
        String portString = port();
        try {
            int port = 0;
            if (Utility.isEmpty(portString))
                port = DEFAULT_PORT;
            else
                port = Integer.parseInt(portString);
            server.setPort(port);
        } catch (Exception e) {
            throw new ConfigurationException(PORT, portString, e);
        }
    }

    private void configureResourceBase(JsUnitServer server) throws ConfigurationException {
        String resourceBaseString = resourceBaseCheckForDefault();
        try {
            server.setResourceBase(new File(resourceBaseString));
        } catch (Exception e) {
            throw new ConfigurationException(RESOURCE_BASE, resourceBaseString, e);
        }
    }

    private String resourceBaseCheckForDefault() {
        String result = resourceBase();
        if (Utility.isEmpty(result))
            result = DEFAULT_RESOURCE_BASE;
        return result;
    }

    public abstract String resourceBase();

    public abstract String port();

    public abstract String logsDirectory();

    public abstract String browserFileNames();

    public abstract String url();
}