package net.jsunit;

import junit.framework.TestCase;
import org.jdom.Document;
import org.jdom.Element;
import org.jdom.input.SAXBuilder;
import sun.net.www.protocol.http.HttpURLConnection;

import java.io.InputStream;
import java.io.StringReader;
import java.net.URL;
import java.util.Iterator;
import java.util.List;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class DistributedTest extends TestCase {
    public static final String REMOTE_MACHINE_URLS = "remoteMachineURLs";

    private List remoteMachineURLs;

    public DistributedTest(String name) {
        super(name);
        String urlsString = System.getProperty(REMOTE_MACHINE_URLS);
        remoteMachineURLs = Utility.listFromCommaDelimitedString(urlsString);
    }

    public void testCollectResults() {
        Iterator it = remoteMachineURLs.iterator();
        while (it.hasNext()) {
            String next = (String) it.next();
            String result = submitRequestTo(next);
            Element resultElement = null;
            try {
                Document document = new SAXBuilder().build(new StringReader(result));
                resultElement = document.getRootElement();
                if (!"result".equals(resultElement.getName()))
                    fail("Unrecognized response from " + next + ": " + result);
            } catch (Exception e) {
                e.printStackTrace();
                fail("Could not parse XML response from " + next + ": " + result);
            }
            assertEquals(next + " failed", "success", resultElement.getText());
        }
    }

    private String submitRequestTo(String remoteMachineName) {
        HttpURLConnection connection = null;
        try {
            URL url = new URL(remoteMachineName + "/jsunit/runner");
            connection = new HttpURLConnection(url, "", 0);
            InputStream in = connection.getInputStream();
            byte[] buffer = new byte[in.available()];
            in.read(buffer);
            in.close();
            return new String(buffer);
        } catch (Exception e) {
            e.printStackTrace();
            fail("Could not submit request to " + remoteMachineName);
            return null;
        } finally {
            if (connection != null)
                connection.disconnect();
        }
    }

}