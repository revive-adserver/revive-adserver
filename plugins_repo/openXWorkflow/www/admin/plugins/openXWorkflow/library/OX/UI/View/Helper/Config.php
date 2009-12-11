<?php

/**
 * A helper that retrives a config value from OX_Common_Config.
 */
class OX_UI_View_Helper_Config
{
    /**
     * Enter description here...
     *
     * @param string $section
     * @param string $key
     * @return mixed config value
     */
    public static function config($section, $key)
    {
        $configValue = OX_Common_Config::instance($section)->get($key);
        return $configValue;
    }
}
