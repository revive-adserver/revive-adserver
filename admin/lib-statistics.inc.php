<?

	$clientCache = array();
	$bannerCache = array();


	function phpAds_buildClientName ($clientID, $clientName)
	{
		return ("[id$clientID] $clientName");
	}


	function phpAds_getClientName ($clientID)
	{
		global $clientCache, $phpAds_tbl_clients;
		
		if (is_array($clientCache[$clientID]))
		{
			$row = $clientCache[$clientID];
		}
		else
		{
			$res = db_query("
			SELECT
				*
			FROM
				$phpAds_tbl_clients
			WHERE
				clientID = $clientID
			") or mysql_die();
			
			$row = @mysql_fetch_array($res);
			
			$clientCache[$clientID] = $row;
		}
		
		return (phpAds_BuildClientName ($clientID, $row[clientname]));
	}


	function phpAds_buildBannerName ($bannerID, $description, $alt)
	{
		$name = "[id$bannerID] ";
		
		if ($description != "")
			$name .= $description;
		else
			$name .= $alt;
		
		return ($name);
	}


	function phpAds_getBannerName ($bannerID)
	{
		global $bannerCache, $phpAds_tbl_banners;
		
		if (is_array($bannerCache[$bannerID]))
		{
			$row = $bannerCache[$bannerID];
		}
		else
		{
			$res = db_query("
			SELECT
				*
			FROM
				$phpAds_tbl_banners
			WHERE
				bannerID = $bannerID
			") or mysql_die();
			
			$row = @mysql_fetch_array($res);
			
			$bannerCache[$bannerID] = $row;
		}
		
		return (phpAds_buildBannerName ($bannerID, $row[description], $row[alt]));
	}


	function phpAds_getBannerCode ($bannerID)
	{
		global $bannerCache, $phpAds_tbl_banners;
		
		if (is_array($bannerCache[$bannerID]))
		{
			$row = $bannerCache[$bannerID];
		}
		else
		{
			$res = db_query("
			SELECT
				*
			FROM
				$phpAds_tbl_banners
			WHERE
				bannerID = $bannerID
			") or mysql_die();
			
			$row = @mysql_fetch_array($res);
			
			$bannerCache[$bannerID] = $row;
		}
		
		return (phpAds_buildBannerCode ($bannerID, $row[banner], $row[active], $row[format], $row[width], $row[height], $row[bannertext]));
	}


	function phpAds_buildBannerCode ($bannerID, $banner, $active, $format, $width, $height, $bannertext)
	{
		if ($active == "true")
		{
			if ($format == "html")
				$buffer = htmlspecialchars (stripslashes ($banner));
			elseif($format == "url")
				$buffer = "<p><img src='$banner' width='$width' height='$height'>";
			else
				$buffer = "<p><img src='../viewbanner.php?bannerID=$bannerID' width='$width' height='$height'>";
		}
		else
		{
			if ($format == "html")
				$buffer = htmlspecialchars (stripslashes( $banner));
			elseif($format == "url")
				$buffer = "<p><img src='$banner' width='$width' height='$height' style='filter: Alpha(Opacity=50)'>";
			else
				$buffer = "<p><img src='../viewbanner.php?bannerID=$bannerID' width='$width' height='$height' style='filter: Alpha(Opacity=50)'>";
		}
		
		if (!$bannertext == "")
			$buffer .= "<br>".$bannertext;
		
		return ($buffer);
	}



