<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Agency extends MAX_Dal_Common
{
    var $table = 'agency';


    /**
     * If the agency has set the logout URL in a database, returns this URL
     * (trimmed).
     * Otherwise, returns 'index.php'.
     *
     * @param string $agencyId
     * @return string Url for redirection after logout.
     */
    function getLogoutUrl($agencyId)
    {
        $doAgency = MAX_DB::staticGetDO('agency', $agencyid);
        if ($doAgency && !empty($doAgency->logout_url)) {
            return trim($doAgency->logout_url);
        }
        return 'index.php';
    }
}
?>
