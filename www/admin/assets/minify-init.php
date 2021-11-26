<?php

$commonJs = [
    'js/jquery-1.2.6-mod.js',
    'js/effects.core.js',
    'js/jquery.bgiframe.js',
    'js/jquery.dimensions.js',
    'js/jquery.metadata.js',
    'js/jquery.validate.js',
    'js/jquery.jqmodal.js',
    'js/jquery.typewatch.js',
    'js/jquery.autocomplete.js',
    'js/jquery.example.js',
    'js/jscalendar/calendar.js',
    'js/jscalendar/lang/calendar-en.js',
    'js/jscalendar/calendar-setup.js',
    'js/jquery.delegate-1.1.min.js',
    'js/jquery.tablesorter.js',
];


$oxpJs = [
    'js/js-gui.js',
    'js/boxrow.js',
    'js/ox.message.js',
    'js/ox.usernamecheck.js',
    'js/ox.accountswitch.js',
    'js/ox.ui.js',
    'js/ox.form.js',
    'js/ox.help.js',
    'js/ox.util.js', //1.3s
    'js/ox.multicheckbox.js',
    'js/ox.dropdown.js',
    'js/ox.navigator.js',
    'js/ox.table.js', //1,2s
    'js/ox.tablesorter.plugins.js',
    'js/formValidation.js',
    'js/ox.security.js',
];

$commonCss = [
    'css/chrome.css',
    'css/jquery.jqmodal.css',
    'css/jquery.autocomplete.css',
    'css/oa.help.css',
    'css/table.css',
    'css/message.css',
    'js/jscalendar/calendar-openads.css',
    'css/icons.css',
];


$oxpCssLtr = [
    'css/interface-ltr.css',
];

$oxpCssRtl = [
    'css/chrome-rtl.css',
    'css/interface-rtl.css',
];

$oxpCssInstallLtr = array_merge($oxpCssLtr, ['css/install.css']);
$oxpCssInstallRtl = array_merge($oxpCssRtl, ['css/install.css']);

$oxpJsInstall = ['js/jquery.simplemodal.min.js', 'js/ox.install.js'];


//define groups used by minfier
$MINIFY_JS_GROUPS = [
    'oxp-js' => array_merge($commonJs, $oxpJs),
    'oxp-js-install' => array_merge($commonJs, $oxpJs, $oxpJsInstall)
];

$MINIFY_CSS_GROUPS = [
    'oxp-css-ltr' => array_merge($commonCss, $oxpCssLtr),
    'oxp-css-rtl' => array_merge($commonCss, $oxpCssRtl),
    'oxp-css-install-ltr' => array_merge($commonCss, $oxpCssInstallLtr),
    'oxp-css-install-rtl' => array_merge($commonCss, $oxpCssInstallRtl)
];
