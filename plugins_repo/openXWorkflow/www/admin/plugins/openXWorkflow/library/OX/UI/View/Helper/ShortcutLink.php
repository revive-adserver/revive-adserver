<?php

/**
 * Renders a link to an OX_UI_Menu_Shortcut. 
 */
class OX_UI_View_Helper_ShortcutLink
{
    public static function shortcutLink(OX_UI_Menu_Shortcut $shortcut, $label = null, $hasNext = false)
    {
        $icon = $shortcut->getIcon();
        $class = '';
        if (!empty($icon)) {
            $class = ' class="inlineIcon' . ($hasNext ? 'HasNext' : '') . ' icon' . $icon . '"'; 
        }
        
        return '<a href="' . $shortcut->getActionUrl() . '"' . $class . '>' . 
            htmlspecialchars(empty($label) ? $shortcut->getLabel() : $label). '</a>';
    }
}
