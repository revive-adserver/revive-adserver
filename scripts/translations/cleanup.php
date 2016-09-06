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

define('MAX_PATH', dirname(dirname(__DIR__)));

$aFiles = array(
    'default.lang.php',
    'maintenance.lang.php',
    'report.lang.php',
    'userlog.lang.php',
    'installer.lang.php',
    'settings-help.lang.php',
    'invocation.lang.php',
    'settings.lang.php',
);

foreach ($aFiles as $file) {
	$path = MAX_PATH.'/lib/max/language/en/'.$file;
    $tokens = token_get_all(file_get_contents($path));

    foreach ($tokens as $key => $token) {
        if (T_CONSTANT_ENCAPSED_STRING === $token[0] && 'str' === substr($token[1], 1, 3)) {
			if ($tokens[$key + 2] == ']') {
				var_dump($tokens[$key + 2]);
				exit;
			}
            $string = substr(trim($token[1], '"\''), 3);

            $output = $status = null;
            $regex = '\\(OA_Admin_Menu_Section.*\\\\b\\|translate.*\\\\b\\|key=\\|str=\\|str\\)'.$string.'\\\\b';
            exec("bash -c \"grep -rl '{$regex}' constants.php lib www plugins_repo\" | grep -v lib/max/language | wc -l", $output, $status);

            if (!$status) {
                if (!trim($output[0])) {
					echo "Removing {$file}: str{$string}".PHP_EOL;
                    exec("sed -i '/\\bstr{$string}\\b/d' {$path}", $status, $output);
                }
            }
        }
    }
}
