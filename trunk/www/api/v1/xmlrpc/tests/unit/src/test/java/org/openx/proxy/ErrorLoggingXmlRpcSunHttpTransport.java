package org.openx.proxy;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClient;
import org.apache.xmlrpc.client.XmlRpcSunHttpTransport;
import org.apache.xmlrpc.common.XmlRpcStreamRequestConfig;

/**
 *
 */
public class ErrorLoggingXmlRpcSunHttpTransport extends XmlRpcSunHttpTransport {

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

	public ErrorLoggingXmlRpcSunHttpTransport(XmlRpcClient client) {
		super(client);
	}

	@Override
	protected Object readResponse(XmlRpcStreamRequestConfig config,
			InputStream input) throws XmlRpcException {
		try {
			byte[] bytes = getBytes(input);
			try {
				return super.readResponse(config, new ByteArrayInputStream(
						bytes));
			} catch (XmlRpcException e) {
				e.printStackTrace();
				System.out.println(new String(bytes));
				throw e;
			}
		} catch (IOException e) {
			throw new XmlRpcException(e.getMessage(), e);
		}
	}

	private static void copy(InputStream is, OutputStream os) throws IOException {
		copy(is, os, BUFF_SIZE_DEFAULT);
	}

	private static void copy(InputStream is, OutputStream os, int bufferSize)
			throws IOException {
		byte[] buf = new byte[bufferSize];
		int read = 0;

		while ((read = is.read(buf)) > 0) {
			os.write(buf, 0, read);
		}
	}

	public static byte[] getBytes(InputStream input) throws IOException {
		ByteArrayOutputStream out = new ByteArrayOutputStream();
		copy(input, out);
		return out.toByteArray();
	}
}
