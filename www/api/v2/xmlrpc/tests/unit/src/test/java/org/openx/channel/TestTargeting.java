/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

package org.openx.channel;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
public class TestTargetingV2 extends ChannelTestCase {

    public void testGetAndSetTargetingWithEmptyArrays()
            throws MalformedURLException, XmlRpcException {

        assertNotNull(websiteId);
        Map<String, Object> myChannel = getChannelParams("test1");

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, myChannel};
        final Integer channelId = (Integer) execute(ADD_CHANNEL_METHOD,
                XMLRPCMethodParameters);

        assertNotNull(channelId);

        try {
            Object[] targeting = new Object[0];
            XMLRPCMethodParameters = new Object[]{sessionId, channelId,
                        targeting};

            final Boolean result = (Boolean) execute(SET_CHANNEL_TARGETING,
                    XMLRPCMethodParameters);

            assertTrue(result);
            XMLRPCMethodParameters = new Object[]{sessionId, channelId};
            final Object[] targetingResult = (Object[]) execute(
                    GET_CHANNEL_TARGETING, XMLRPCMethodParameters);

            assertEquals(targetingResult.length, 0);
        } finally {
            deleteChannel(channelId);
        }
    }

    @SuppressWarnings("unchecked")
    public void testGetAndSetTargeting() throws MalformedURLException,
            XmlRpcException {

        assertNotNull(websiteId);
        Map<String, Object> myChannel = getChannelParams("test1");

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, myChannel};
        final Integer channelId = (Integer) execute(ADD_CHANNEL_METHOD,
                XMLRPCMethodParameters);

        assertNotNull(channelId);

        try {

            Map<String, Object> targetingInfo1 = new HashMap<String, Object>();
            targetingInfo1.put(TARGETING_LOGICAL, "and");
            targetingInfo1.put(TARGETING_TYPE, "deliveryLimitations:Client:Browser");
            targetingInfo1.put(TARGETING_COMPATISON, "=");
            targetingInfo1.put(TARGETING_DATA, "");

            Object[] targeting = new Object[]{targetingInfo1};

            XMLRPCMethodParameters = new Object[]{sessionId, channelId,
                        targeting};
            final Boolean result = (Boolean) execute(SET_CHANNEL_TARGETING,
                    XMLRPCMethodParameters);
            assertTrue(result);

            XMLRPCMethodParameters = new Object[]{sessionId, channelId};
            final Object XMLRPCResult[] = (Object[]) execute(
                    GET_CHANNEL_TARGETING, XMLRPCMethodParameters);

            assertEquals(XMLRPCResult.length, 1);

            Map<String, Object> targetingResult = (Map<String, Object>) XMLRPCResult[0];

            checkParameter(targetingResult, targetingInfo1, TARGETING_LOGICAL);
            checkParameter(targetingResult, targetingInfo1, TARGETING_TYPE);
            checkParameter(targetingResult, targetingInfo1, TARGETING_COMPATISON);
            checkParameter(targetingResult, targetingInfo1, TARGETING_DATA);
        } finally {
            deleteChannel(channelId);
        }
    }

    public void testGetAndSetTargetingWithError() throws MalformedURLException,
            XmlRpcException {

        assertNotNull(websiteId);
        Map<String, Object> myChannel = getChannelParams("test1");

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, myChannel};
        final Integer channelId = (Integer) execute(ADD_CHANNEL_METHOD,
                XMLRPCMethodParameters);
        assertNotNull(channelId);

        try {

            Map<String, Object> targetingInfo1 = new HashMap<String, Object>();
            targetingInfo1.put(TARGETING_LOGICAL, "and");
            targetingInfo1.put(TARGETING_TYPE, "deliveryLimitations:Geo:Country");
            targetingInfo1.put(TARGETING_COMPATISON, "=");

            Object[] targeting = new Object[]{targetingInfo1};

            try {
                XMLRPCMethodParameters = new Object[]{sessionId, channelId,
                            targeting};
                execute(SET_CHANNEL_TARGETING, XMLRPCMethodParameters);
                fail();
            } catch (XmlRpcException e) {
                assertEquals(ErrorMessage.getMessage(ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS,
                        "data"), e.getMessage());
            }
        } finally {
            deleteChannel(channelId);
        }
    }
}
