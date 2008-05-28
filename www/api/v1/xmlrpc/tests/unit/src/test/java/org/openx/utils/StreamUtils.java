/**
 * 
 */
package org.openx.utils;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.Reader;
import java.io.Writer;


/**
 * @version $Rev$ $Date:: 2007-01-01 00:00:00 #$ $LastChangedBy$
 * @author $Author$
 */

public class StreamUtils
{
    public static final int BUFF_SIZE_1K = 1024;
    public static final int BUFF_SIZE_2K = 2 * 1024;
    public static final int BUFF_SIZE_4K = 4 * 1024;
    public static final int BUFF_SIZE_8K = 8 * 1024;
    public static final int BUFF_SIZE_10K = 10 * 1024;
    public static final int BUFF_SIZE_16K = 16 * 1024;
    public static final int BUFF_SIZE_32K = 32 * 1024;
    public static final int BUFF_SIZE_64K = 64 * 1024;
    public static final int BUFF_SIZE_100K = 100 * 1024;
    public static final int BUFF_SIZE_128K = 128 * 1024;
    public static final int BUFF_SIZE_256K = 256 * 1024;
    public static final int BUFF_SIZE_512K = 512 * 1024;
    public static final int BUFF_SIZE_1M = 1024 * 1024;
    public static final int BUFF_SIZE_DEFAULT = BUFF_SIZE_1K;


    public static void copy(InputStream is, OutputStream os)
        throws IOException
    {
        copy(is, os, BUFF_SIZE_DEFAULT);
    }


    public static void copy(InputStream is, OutputStream os, int bufferSize)
        throws IOException
    {
        byte[] buf = new byte[bufferSize];
        int read = 0;

        while ( (read = is.read(buf)) > 0) {
            os.write(buf, 0, read);
        }
    }


    public static void copy(Reader reader, Writer writer)
        throws IOException
    {
        copy(reader, writer, BUFF_SIZE_DEFAULT);
    }


    public static void copy(Reader reader, Writer writer, int bufferSize)
        throws IOException
    {
        char[] buf = new char[bufferSize];
        int read = 0;

        while ( (read = reader.read(buf)) > 0) {
            writer.write(buf, 0, read);
        }
    }


    public static String getString(InputStream inputStream, String charsetName)
        throws IOException
    {
        return new String(getBytes(inputStream), charsetName);
    }


    public static String getString(InputStream inputStream)
        throws IOException
    {
        return new String(getBytes(inputStream));
    }


    public static byte[] getBytes(InputStream input)
        throws IOException
    {
        ByteArrayOutputStream out = new ByteArrayOutputStream();
        copy(input, out);
        return out.toByteArray();
    }


    public static String getStringSnippet(InputStream is)
        throws IOException
    {
        ByteArrayOutputStream out = new ByteArrayOutputStream();
        byte[] buf = new byte[1000];
        int read = 0;
        while ( (read = is.read(buf)) > 0) {
            out.write(buf, 0, read);
        }
        return new String(out.toByteArray());
    }
}
