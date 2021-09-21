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

require 'Minify.php';

/**
 * Common place for the min request handling code.
 */
class OX_UI_Minify_Server
{
    public static function serve()
    {
        // try to disable output_compression (may not have an effect)
        ini_set('zlib.output_compression', '0');
        
        Minify::setCache(OX_PATH . '/var/cache', true);
        
        if (isset($_GET['g'])) {
            // serve!
            $options = [];
            $options['minApp']['groupsOnly'] = true;
            $options['rewriteCssUris'] = false;
            $options['minApp']['groups'] = self::prepareGroups();
            Minify::serve('MinApp', $options);
        } else {
            header("Location: /");
            exit();
        }
    }


    private static function prepareGroups()
    {
        global $MINIFY_JS_GROUPS;
        global $MINIFY_CSS_GROUPS;
        
        $groups = array_merge($MINIFY_JS_GROUPS);
        foreach ($MINIFY_CSS_GROUPS as $key => $urls) {
            $sources = [];
            foreach ($urls as $url) {
                //XXX: why do we always setup CSS sources when request is for one
                //group specified in 'g' parameter?
                self::addCssSource($url, $sources);
            }
            $groups[$key] = $sources;
        }
        
        return $groups;
    }


    /**
     * As the images from CSS will be resolved relative to the min.php script,
     * we need to prepend some path element to each image url so that they load properly.
     * This is done by a custom per-css url minification option.
     */
    private static function addCssSource($fileName, &$array)
    {
        $lastSlashPos = strrpos($fileName, '/');
        $baseDir = '';
        if ($lastSlashPos !== false) {
            $baseDir = substr($fileName, 0, $lastSlashPos + 1);
        }
        
        $array[] = new Minify_Source(['filepath' => $fileName,
                'minifyOptions' => [
                        'prependRelativePath' => $baseDir]]);
    }
}
