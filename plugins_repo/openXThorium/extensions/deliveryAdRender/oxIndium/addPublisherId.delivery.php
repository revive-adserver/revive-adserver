<?php

require_once MAX_PATH . '/extensions/deliveryAdRender/oxThorium/marketplace.php';

function Plugin_deliveryAdRender_oxIndium_addPublisherId_Delivery_preCacheStore_accounttzs($name, &$cache)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $query = "
        SELECT
            a.account_id AS account_id,
            apa.value AS publisherid
        FROM
            {$aConf['table']['prefix']}{$aConf['table']['accounts']} AS a JOIN
            {$aConf['table']['prefix']}{$aConf['table']['account_preference_assoc']} AS apa ON (apa.account_id = a.account_id) JOIN
            {$aConf['table']['prefix']}{$aConf['table']['preferences']} AS p ON (p.preference_id = apa.preference_id)
        WHERE
            a.account_type IN ('ADMIN', 'MANAGER') AND
            p.preference_name = 'oxThorium_bidpref_PublisherId'
    ";
    $res = OA_Dal_Delivery_query($query);
    if (is_resource($res)) {
        while ($row = mysql_fetch_assoc($res)) {
            $accountId = (int)$row['account_id'];
            if (isset($cache['adminAccountId'])
                && $accountId === $cache['adminAccountId']) {
                $cache['oxThorium']['defaultPublisherId'] = $row['publisherid'];
            } else {
                $cache['oxThorium']['aAccountsPublisherId'][$accountId]
                    = $row['publisherid'];
            }
        }
    }
}

?>