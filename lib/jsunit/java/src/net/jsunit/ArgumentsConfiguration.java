package net.jsunit;

import java.util.Iterator;
import java.util.List;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class ArgumentsConfiguration extends Configuration {
    private String port;
    private String resourceBase;
    private String logsDirectory;
    private String url;
    private String browserFileNames;

    public ArgumentsConfiguration(List args) {
        init(args);
    }

    private void init(List args) {
        for (Iterator it = args.iterator(); it.hasNext();) {
            String argument = (String) it.next();
            if (argument.equals("-" + PORT))
                this.port = (String) it.next();
            if (argument.equals("-" + RESOURCE_BASE))
                this.resourceBase = (String) it.next();
            if (argument.equals("-" + LOGS_DIRECTORY))
                this.logsDirectory = (String) it.next();
            if (argument.equals("-" + URL))
                this.url = (String) it.next();
            if (argument.equals("-" + BROWSER_FILE_NAMES))
                this.browserFileNames = (String) it.next();
        }
    }

    public String resourceBase() {
        return resourceBase;
    }

    public String port() {
        return port;
    }

    public String logsDirectory() {
        return logsDirectory;
    }

    public String browserFileNames() {
        return browserFileNames;
    }

    public String url() {
        return url;
    }
}