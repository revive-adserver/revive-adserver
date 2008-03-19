import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

public class OapSqlMaintenance {

	private static final int HOW_MANY_CLICKS = 70000;
	private static final int IMPRESSIONS_PER_CLICK = 100;
	private static final int ZONE_RANGE = 5;
	private static final int BANNER_RANGE_IN_ZONE = 5;
	private static final String TRAFFIC_TIMESTAMP = "2007-11-28 15:09:13";
	private static final String FILE_NAME = "main_oa_l_tests_"+HOW_MANY_CLICKS+".sql";
	private int impression = 0;
	private int click = 0;
	
	/**
	 * @param args
	 */
	public static void main(String[] args) {

		File file = new File(FILE_NAME);
		int iZoneIndex = 0;
		int iBannerIndex = 0;
		try {
			FileWriter writer = new FileWriter(file);
			OapSqlMaintenance sql = new OapSqlMaintenance();
			for (int i = 0; i < HOW_MANY_CLICKS; i++) {
				iZoneIndex = (i % ZONE_RANGE) +1;
				iBannerIndex = (((int) (Math.random()*100)) % BANNER_RANGE_IN_ZONE)+(i % ZONE_RANGE)*BANNER_RANGE_IN_ZONE+1;
				//System.out.println(iZoneIndex+" "+iBannerIndex);
				writer.write(sql.getClick(iBannerIndex, iZoneIndex)+'\n');
				for (int j = 0; j < IMPRESSIONS_PER_CLICK; j++) {
					writer.write(sql.getImpression(iBannerIndex, iZoneIndex)+'\n');
				}
			}
			writer.flush();			
			writer.close();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	private String getImpression(int iBannerIndex, int iZoneIndex) {
		impression++;
		return "INSERT INTO `oa_data_raw_ad_impression` (`viewer_id`, `viewer_session_id`, `date_time`," +
				" `ad_id`, `creative_id`, `zone_id`, `channel`, `channel_ids`, `language`, `ip_address`," +
				" `host_name`, `country`, `https`, `domain`, `page`, `query`, `referer`, `search_term`," +
				" `user_agent`, `os`, `browser`, `max_https`, `geo_region`, `geo_city`, `geo_postal_code`," +
				" `geo_latitude`, `geo_longitude`, `geo_dma_code`, `geo_area_code`, `geo_organisation`," +
				" `geo_netspeed`, `geo_continent`) " +
				"VALUES('0d1fb62a48ff3479bc2bfb85a20f99a7', '', '"+
				TRAFFIC_TIMESTAMP+"', " +
				iBannerIndex + ", 0, " +
				iZoneIndex + ", NULL, '|'," +
				" 'pl,en-us;q=0.7,en;q=0.3', '85.221.229.114', '85.221.229.114', NULL, 0, '85.221.229.114'," +
				" '/oap_test/', NULL, NULL, '', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9'," +
				" '', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
	}
	
	private String getClick(int iBannerIndex, int iZoneIndex) {
		click++;
		return "INSERT INTO `oa_data_raw_ad_click` (`viewer_id`, `viewer_session_id`, `date_time`," +
				" `ad_id`, `creative_id`, `zone_id`, `channel`, `channel_ids`, `language`, `ip_address`," +
				" `host_name`, `country`, `https`, `domain`, `page`, `query`, `referer`, `search_term`," +
				" `user_agent`, `os`, `browser`, `max_https`, `geo_region`, `geo_city`, `geo_postal_code`," +
				" `geo_latitude`, `geo_longitude`, `geo_dma_code`, `geo_area_code`, `geo_organisation`," +
				" `geo_netspeed`, `geo_continent`) " +
				"VALUES('0d1fb62a48ff3479bc2bfb85a20f99a7', ''," +
				" '"+TRAFFIC_TIMESTAMP+"', " +
				iBannerIndex + ", 0, " +
				iZoneIndex + ", NULL, NULL, 'pl,en-us;q=0.7,en;q=0.3', '85.221.229.114'," +
				" '85.221.229.114', NULL, NULL, NULL, NULL, NULL, NULL, ''," +
				" 'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9'," +
				" '', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
	}
}
