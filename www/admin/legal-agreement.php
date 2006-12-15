<?php
/**
 * ... for Max Media Manager
 *
 * @since 0.3.22 - Apr 11, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id: legal-agreement.php 4736 2006-04-24 14:26:57Z matteo@beccati.com $
 */

// Define a constant to avoid endless redirection in case the agreement is needed
define ('MAX_SKIP_LEGAL_AGREEMENT', 1);

// Require the initialisation file
require_once '../../init.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';
require_once MAX_PATH . '/lib/max/Admin/LegalAgreement.php';

$legal_agreement_page = new MAX_Admin_LegalAgreement();

if ($legal_agreement_page->doesCurrentUserNeedToSeeAgreement()) {
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        $legal_agreement_page->handlePost($_POST);
    } else {
        $legal_agreement_page->handleGet();
    }
} else {
     MAX_Admin_Redirect::redirect('index.php');
}

?>
