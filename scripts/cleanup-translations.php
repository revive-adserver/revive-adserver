<?php

define('MAX_PATH', dirname(dirname(__FILE__)));

$aFiles = array(
    'default.lang.php',
);

foreach ($aFiles as $file) {
    $tokens = token_get_all(file_get_contents(MAX_PATH.'/lib/max/language/en/'.$file));

    foreach ($tokens as $token) {
        if (T_CONSTANT_ENCAPSED_STRING === $token[0] && 'str' === substr($token[1], 1, 3)) {
            $string = substr(trim($token[1], '"\''), 3);

            $output = $status = null;
            $regex = '\\(OA_Admin_Menu_Secti.*\\\\b\\|str=\\|str\\)'.$string.'\\\\b';
            exec("bash -c \"grep -rl '{$regex}' lib www\" | grep -v lib/max/language | wc -l", $output, $status);

            if (!$status) {
                if (!trim($output[0])) {
                    var_dump($string);
                }
            }
        }
    }
}