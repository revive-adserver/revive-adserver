<?
function acl_check($request, $row) {
	global $phpAds_tbl_acls;
	global $phpAds_db;
	$bannerID = $row['bannerID'];
	if (($res = mysql_db_query($phpAds_db, "SELECT * FROM $phpAds_tbl_acls
		WHERE bannerID = $bannerID ORDER by acl_order")) == 0){ 
		return(0);
	}
	while ($aclrow = mysql_fetch_array($res)) {
		switch ($aclrow['acl_type']) {
			case 'clientip':
				$result = acl_check_clientip($request, $aclrow);
				break;
			case 'useragent':
				$result = acl_check_useragent($request,
								$aclrow);
				break;
			case 'weekday':
				$result = acl_check_weekday($request,
								$aclrow);
				break;
			case 'domain':
				$result = acl_check_domain($request, $aclrow);
				break;
			case 'source':
				$result = acl_check_source($request, $aclrow);
				break;
			case 'time':
				$result = acl_check_time($request, $aclrow);
				break;
			default:
				return(0);
		}
		if ($result != -1) {
			return($result);
		}	
	}
	return(1); 
}

function acl_check_weekday($request, $aclrow) {
	$data = $aclrow['acl_data'];
	$day = $request['weekday'];
	if ($day == $data) {
		switch ($aclrow['acl_ad']) {
			case 'allow':
				return(1);
			case 'deny';
				return(0);
			default:
				return(-1);
		}
	}
	return(-1);
}


function acl_check_useragent($request, $aclrow) {
	$data = $aclrow['acl_data'];
	$agent = $request['user_agent'];
	if (eregi($data, $agent)) {
		switch ($aclrow['acl_ad']) {
			case 'allow':
				return(1);
			case 'deny';
				return(0);
			default:
				return(-1);
		}
	}
	return(-1);	
}

function acl_check_clientip($request, $aclrow) {
	$data = $aclrow['acl_data'];
	$host = $request['remote_host'];
	list ($net, $mask) = explode('/', $data);
	$net = explode('.', $net);
	$pnet = pack('C4', $net[0], $net[1], $net[2], $net[3]);
	$mask = explode('.', $mask);
	$pmask = pack('C4', $mask[0], $mask[1], $mask[2], $mask[3]);
	$host = explode('.', $host);
	$phost = pack('C4', $host[0], $host[1], $host[2], $host[3]);
	if (($phost & $pmask) == $pnet) {
		switch ($aclrow['acl_ad']) {
			case 'allow':
				return(1);
			case 'deny';
				return(0);
			default:
				return(-1);
		}
	}
	return(-1);
}

function acl_check_domain($request, $aclrow) {
	$data = $aclrow['acl_data'];
	$ip = $request['remote_host'];
	$host = gethostbyaddr($ip);
	if ($host == $ip)
	{
		return(-1);
	} else
	{
		$pos = strrpos($host,".");
		$domain = substr($host,$pos+1);
		if (strtolower($domain) == strtolower($data))
		{
			switch ($aclrow['acl_ad']) {
				case 'allow':
					return(1);
				case 'deny':
					return(0);
				default:
					return(-1);
			}
		}
		return(0);
	}
}

function acl_check_source($request, $aclrow) {
	$data = $aclrow['acl_data'];
	$source = $request['source'];
	if (strtolower($source) == strtolower($data))
	{
		switch ($aclrow['acl_ad']) {
			case 'allow':
				return(1);
			case 'deny':
				return(0);
			default:
				return(-1);
		}
	}
	return(0);
}

function acl_check_time($request, $aclrow) {
	$data = $aclrow['acl_data'];
	$time = $request['time'];
	if ($time == $data) {
		switch ($aclrow['acl_ad']) {
			case 'allow':
				return(1);
			case 'deny';
				return(0);
			default:
				return(-1);
		}
	}
	return(-1);
}

?>
