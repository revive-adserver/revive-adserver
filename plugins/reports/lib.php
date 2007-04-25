<?PHP

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

/*--------------------------------------------------------------*/
/* Function for generating header for xls publisher reports     */
/*--------------------------------------------------------------*/
function & generateXLSHeader(& $workbook, $reportName, $strStartDate, $strEndDate, $subjectId, $reportDescription = '', $reportType = 'publisher')
{
	$strTodayDate = date(str_replace('%','',$GLOBALS['date_format']), time());

    $columnHeader =& $workbook->addFormat();
    $columnHeader->setBold();

    // setting filename for report
    $workbook->send( createReportFilename($reportName,$strStartDate,$strEndDate) );
    $worksheet =& $workbook->addWorksheet(reportsDirifyWorkSheetName(substr($reportName . " Report",0,30)));

    // setting column width
    $worksheet->setColumn(0,0,30);
    $worksheet->setColumn(1,9,15);

    // Report "not structural" data
    $worksheet->write(0,0,'Report:', $columnHeader);
    $worksheet->write(0,1,$reportName);

    $worksheet->write(1,0,'Report Date:', $columnHeader);
    $worksheet->write(1,1,$strTodayDate);

    $worksheet->write(2,0,'Report Period:', $columnHeader);
    $worksheet->write(2,1,$strStartDate . ' - ' . $strEndDate);

    switch ($reportType) {
        case 'publisher':
            $worksheet->write(3,0,'Site:', $columnHeader);
            $worksheet->write(3,1,getAffiliateSite($subjectId));
            break;
        case 'advertiser':
            $worksheet->write(3,0,'Advertiser:', $columnHeader);
            $worksheet->write(3,1,getClientName($subjectId));
            break;
        case 'zone':
            $worksheet->write(3,0,'Zone:', $columnHeader);
            $worksheet->write(3,1,getZoneName($subjectId));
            break;
        default:
            break;
    }

    $worksheet->write(5,0,$reportDescription);

    return $worksheet;
}

function createReportFilename($reportName, $startDate, $endDate) {
    // reformat date strings
    $aStartDate = explode('-', $startDate);
    $aEndDate = explode('-', $endDate);
    $startDate = $aStartDate[2].'-'.$aStartDate[1].'-'.$aStartDate[0];
    $endDate = $aEndDate[2].'-'.$aEndDate[1].'-'.$aEndDate[0];

    return $reportName . ' from ' . date('Y-M-d', strtotime($startDate)) . ' to ' . date('Y-M-d', strtotime($endDate)) . '.xls';
}

/*-----------------------------------------------------*/
/* Function for generating "total" fow at the end of   */
/* passed data table (normal array)                    */
/*-----------------------------------------------------*/
function addTotals(& $table) {
    global $strTotal;

    $totalRow = array();

    foreach($table as $id => $row) {
        foreach($row as $fieldName => $fieldValue) {
            if(isset($totalRow[$fieldName])) {
                if(is_numeric($totalRow[$fieldName])) {
                    $totalRow[$fieldName] += $fieldValue;
                } else {
                    $totalRow[$fieldName] = '';
                }
            } else {
                $totalRow[$fieldName] = (string)$fieldValue;
            }
        }
    }

    // first column of the table is "Total"
    if(list($key, $val) = each($totalRow)) {
        $totalRow[$key] = $strTotal;
    }

    $table[] = $totalRow;
}

/*----------------------------------------------------------------*/
/* Function for getting website name for particular affiliate     */
/*----------------------------------------------------------------*/

function getAffiliateSite($affiliate_id)
{
    $conf = & $GLOBALS['_MAX']['CONF'];
	if (phpAds_isUser(phpAds_Admin))
	{
		$query =
			"SELECT website".
			" FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
			" WHERE affiliateid=".$affiliate_id ;
	}
	elseif (phpAds_isUser(phpAds_Agency))
	{
		$query =
			"SELECT website".
			" FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
			" WHERE agencyid=".phpAds_getUserID().
			"   AND affiliateid=".$affiliate_id;
	}
	elseif (phpAds_isUser(phpAds_Client))
	{
		$query =
			"SELECT website".
			" FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
			" WHERE affiliateid=".phpAds_getUserID().
			"   AND affiliateid=".$affiliate_id;
	}
	$res = phpAds_dbQuery($query);

	if ($row = phpAds_dbFetchArray($res))
	   return "[id".$affiliate_id."] ".$row['website'];
	else
	   return 'none';
}

/*-------------------------------------------------------*/
/* Fetch the client name from the database               */
/*-------------------------------------------------------*/

function getClientName($clientid)
{
    if ($clientid != '' && $clientid != 0)
    {
        $client_details = phpAds_getClientDetails($clientid);
        return $client_details['clientname'];
    }
    else
        return ($strUntitled);
}

/*-------------------------------------------------------*/
/* Fetch the zone name from the database               */
/*-------------------------------------------------------*/

function getZoneName($zoneid)
{
    if ($zoneid != '' && $zoneid != 0)
    {
        $zone_name = phpAds_getZoneName($zoneid);
        return strip_tags($zone_name);
    }
    else
        return ($strUntitled);
}

/*----------------------------------------------------------------*/
/* Get format string for decimal percentages based on preferences */
/*----------------------------------------------------------------*/

function getPercentageDecimalFormat()
{
    for ($cnt = 0 ; $cnt < $GLOBALS['pref']['percentage_decimals']; $cnt++) {
        $strPercentageDecimalPlaces .= '0';
    }
    $strPercentageDecimalFormat = '#,##0.'.$strPercentageDecimalPlaces.';-#,##0.'.$strPercentageDecimalPlaces.';-';

    return $strPercentageDecimalFormat;
}


//  from http://kalsey.com/2004/07/dirify_in_php/
function reportsDirifyWorkSheetName($s)
{
     $s = reportsConvertHighAscii($s);   ## convert high-ASCII chars to 7bit.
     $s = strip_tags($s);                       ## remove HTML tags.
     $s = preg_replace('!&[^;\s]+;!','',$s);    ## remove HTML entities.
     $s = preg_replace('![^\w\s]!','',$s);      ## remove non-word/space chars.
     return $s;
}

function reportsConvertHighAscii($s)
{
 	$HighASCII = array(
 		"!\xc0!" => 'A',    # A`
 		"!\xe0!" => 'a',    # a`
 		"!\xc1!" => 'A',    # A'
 		"!\xe1!" => 'a',    # a'
 		"!\xc2!" => 'A',    # A^
 		"!\xe2!" => 'a',    # a^
 		"!\xc4!" => 'Ae',   # A:
 		"!\xe4!" => 'ae',   # a:
 		"!\xc3!" => 'A',    # A~
 		"!\xe3!" => 'a',    # a~
 		"!\xc8!" => 'E',    # E`
 		"!\xe8!" => 'e',    # e`
 		"!\xc9!" => 'E',    # E'
 		"!\xe9!" => 'e',    # e'
 		"!\xca!" => 'E',    # E^
 		"!\xea!" => 'e',    # e^
 		"!\xcb!" => 'Ee',   # E:
 		"!\xeb!" => 'ee',   # e:
 		"!\xcc!" => 'I',    # I`
 		"!\xec!" => 'i',    # i`
 		"!\xcd!" => 'I',    # I'
 		"!\xed!" => 'i',    # i'
 		"!\xce!" => 'I',    # I^
 		"!\xee!" => 'i',    # i^
 		"!\xcf!" => 'Ie',   # I:
 		"!\xef!" => 'ie',   # i:
 		"!\xd2!" => 'O',    # O`
 		"!\xf2!" => 'o',    # o`
 		"!\xd3!" => 'O',    # O'
 		"!\xf3!" => 'o',    # o'
 		"!\xd4!" => 'O',    # O^
 		"!\xf4!" => 'o',    # o^
 		"!\xd6!" => 'Oe',   # O:
 		"!\xf6!" => 'oe',   # o:
 		"!\xd5!" => 'O',    # O~
 		"!\xf5!" => 'o',    # o~
 		"!\xd8!" => 'Oe',   # O/
 		"!\xf8!" => 'oe',   # o/
 		"!\xd9!" => 'U',    # U`
 		"!\xf9!" => 'u',    # u`
 		"!\xda!" => 'U',    # U'
 		"!\xfa!" => 'u',    # u'
 		"!\xdb!" => 'U',    # U^
 		"!\xfb!" => 'u',    # u^
 		"!\xdc!" => 'Ue',   # U:
 		"!\xfc!" => 'ue',   # u:
 		"!\xc7!" => 'C',    # ,C
 		"!\xe7!" => 'c',    # ,c
 		"!\xd1!" => 'N',    # N~
 		"!\xf1!" => 'n',    # n~
 		"!\xdf!" => 'ss'
 	);
 	$find = array_keys($HighASCII);
 	$replace = array_values($HighASCII);
 	$s = preg_replace($find,$replace,$s);
    return $s;
}

?>
