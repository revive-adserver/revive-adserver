<?php

$commonJs = array (
//        'assets/base/js/jquery-1.3.2.js', 
        'assets/base/js/ui.core.js', 
        'assets/base/js/ui.datepicker.js', 
        'assets/base/js/ox.form.js', 
        'assets/base/js/ox.util.js', 
        'assets/base/js/ox.dropdown.js', 
        'assets/base/js/ox.multicheckbox.js', 
        'assets/base/js/ox.table.js', 
        'assets/base/js/ox.reports.js');

$commonCss = array (
        //'assets/base/css/reset.css',
        //'assets/base/css/chrome.css', 
        'assets/base/css/form.css', 
        'assets/base/css/message.css', 
        /*'assets/base/css/icons.css',*/ 
        'assets/base/css/table.css', 
        'assets/base/css/report.css');

$jqueryTheme = array('assets/base/css/theme/ui.accordion.css',
        'assets/base/css/theme/ui.core.css',
        'assets/base/css/theme/ui.datepicker.css',
        'assets/base/css/theme/ui.dialog.css',
        'assets/base/css/theme/ui.progressbar.css',
        'assets/base/css/theme/ui.resizable.css',
        'assets/base/css/theme/ui.slider.css',
        'assets/base/css/theme/ui.tabs.css',
        'assets/base/css/theme/ui.theme.css');

$wkJs = array('assets/wk/js/ox.wizard.js', 'assets/wk/js/jquery.hoverIntent.minified.js');
$wkCss = array('assets/wk/css/custom.css');


$MINIFY_JS_GROUPS['openXWorkflow-js'] = array_merge($commonJs, $wkJs);
$MINIFY_CSS_GROUPS['openXWorkflow-css'] = array_merge($commonCss, $jqueryTheme, $wkCss); 
