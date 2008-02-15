<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

// Required files
require_once MAX_PATH . '/www/admin/lib-gd.inc.php';
require_once MAX_PATH . '/plugins/statistics/targeting/TargetingController.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once 'HTML/Template/Flexy.php';

$flexy_options = array(
    'templateDir'       => MAX_PATH . '/plugins/statistics/targeting/themes',
    'compileDir'        => MAX_PATH . '/var/templates_compiled',
);
$output = new HTML_Template_Flexy($flexy_options);

$controller = new Statistics_TargetingController();
$controller->placement_id = $campaignid;

$controller->useDefaultDataAccessLayer();
$point_in_time = $_GET['day'];
$date = new Date($point_in_time);

//$view should be set by the page that include()s this file
$tabindex = 0;
$pageName = 'stats.php?entity=placement&breakdown=target';
$default_period = 'last7days';
if ($_GET['period_preset']) {
    $period_preset = $_GET['period_preset'];
} else {
    $period_preset = $default_period;
}

$controller->base_url_for_day_overview = 'stats.php?entity=placement&breakdown=target-daily' . '&clientid=' . $clientid . '&campaignid=' . $campaignid;

if ($view == 'day_overview') {
    $controller->setPeriod('d', $date);
    MAX_displayPeriodSelectionForm('d', $pageName, $tabindex, $lib_targetstats_params);
    $template_name = 'placement_day_overview.html';
} else {
    $pageName = 'stats.php?entity=placement&breakdown=target';
    $controller->setPeriod($period_preset, $date);
    $aDates = array(
        'day_begin' => $controller->getStartDateString(),
        'day_end' => $controller->getEndDateString()
    );
    MAX_displayDateSelectionForm($period_preset, $period_start, $period_end, $pageName, $tabindex, $lib_targetstats_params);
    $template_name = 'placement_summary.html';
}
$output->compile($template_name);
$output->outputObject($controller);

?>
