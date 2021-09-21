<?php

require_once MAX_PATH . '/lib/OA/Admin/NumberFormat.php';

function smarty_modifier_formatNumber($number)
{
    return OA_Admin_NumberFormat::formatNumber($number, 0);
}
