<?php

require_once MAX_PATH . "/www/admin/plugins/videoReport/lib/Url/Url.php";

/**
 * Smarty {url} function plugin.
 * Generates a URL with the specified parameters modified.
 *
 * Examples:
 * <pre>
 * {url module="API"} will rewrite the URL modifying the module GET parameter
 * {url module="API" method="getKeywords"} will rewrite the URL modifying the parameters module=API method=getKeywords
 * </pre>
 *
 * @param $name=$value of the parameters to modify in the generated URL
 * @return	string Something like index.php?module=X&action=Y
 */
function smarty_function_url($params, &$smarty)
{
    return OX_Vast_Url::getCurrentScriptName() . OX_Vast_Url::getCurrentQueryStringWithParametersModified($params);
}
