<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Central/CurrencyFX.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.2");

$currencyFX = new OA_Central_CurrencyFX();


echo "<form method='POST'>";
echo "<table>";
echo "<tr><TD>Amount</TD><TD><input name=\"amount\" value=\"{$_POST['amount']}\"/></TD><tr>";
echo '<tr><TD>Source currency</TD><TD><input name="source" value="' . $_POST['source'] . '"/></TD><tr>';
echo '<tr><TD>Destination currency</TD><TD><input name="dest" value="' . $_POST['dest'] . '"/></TD><tr>';

if (isset($_POST['amount'])) {
	$destinationAmmount = $currencyFX->translateToVisibleValue($_POST['amount'], $_POST['source'],$_POST['dest']);
	echo "<tr><TD>Destination ammount</TD><TD>$destinationAmmount</TD><tr>";
}
echo '<tr><TD><input type="submit"></TD><tr>';
echo "</table>";
echo "</form>";

echo "<BR>";

echo "<table border=1>";
$feedWithMetadata = $currencyFX->getCurrencyFXWithMetadata();
//$feed = $currencyFX->getCurrencyFX("USD");

$baseCurrency = $_POST['baseCurrency'];

if (isset($baseCurrency)) {
	$feed = $currencyFX->getCurrencyFX($baseCurrency);
}
else {
	$feed = $currencyFX->getCurrencyFX();
}
ksort($feed);

echo "Data from ${feedWithMetadata['downloadUrl']} (${feedWithMetadata['downloadDate']}) <BR>";
foreach ($feed as $currency => $rate) {
	echo "<TR><TD>$currency</TD><TD>$rate</TD><TD>" . (1/$rate) . "</TD></TR>";
}
echo "</table>";

echo "<form method='POST'>";
echo "<input name=\"baseCurrency\" value=\"{$baseCurrency}\"/>";
echo "</form>";


phpAds_PageFooter();

?>
