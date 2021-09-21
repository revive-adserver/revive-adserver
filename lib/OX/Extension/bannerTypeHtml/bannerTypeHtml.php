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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once LIB_PATH . '/Plugin/Component.php';

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 * @abstract
 */
class Plugins_BannerTypeHTML extends OX_Component
{
    public function getStorageType()
    {
        return 'html';
    }

    /**
     * Return the media (content) type
     *
     */
    public function getContentType()
    {
        return 'html';
    }

    /**
     * Return type of plugin
     *
     * @return string A string describing the type of plugin.
     */
    public function getOptionDescription()
    {
        return 'Generic HTML Banner';
    }

    /**
     * Append type-specific form elements to the base form
     *
     * @param object &$form
     * @param array &$row
     */
    public function buildForm(&$form, &$row)
    {
        if (!function_exists('_adRenderBuildImageUrlPrefix')) {
            require_once(MAX_PATH . '/lib/max/Delivery/adRender.php');
        }

        $form->setAttribute("onSubmit", "return max_formValidateHtml(this.banner)");
        $header = $form->createElement('header', 'header_html', $GLOBALS['strHTMLBanner'] . " -  banner code");
        $header->setAttribute('icon', 'icon-banner-html.gif');
        $form->addElement($header);

        $adPluginsList = [
            'none' => $GLOBALS['strDoNotAlterHtml'],
            '' => $GLOBALS['strAdserverTypeGeneric'],
        ];

        $imgUrlPrefixJs = json_encode(_adRenderBuildImageUrlPrefix());

        $useTinyMCE = !empty($GLOBALS['_MAX']['PREF']['ui_html_wyswyg_enabled']) &&
            !preg_match('#<(?:script|iframe)#i', $row['htmltemplate']);

        $htmlG['textarea'] = $form->createElement(
            'textarea',
            'htmltemplate',
            null,
            [
                'class' => 'code', 'cols' => '70', 'rows' => '10', 'wrap' => 'off',
                'dir' => 'ltr', 'style' => 'width:728px;'
            ]
        );
        $aSelectAttributes = ['id' => 'adserver', 'style' => 'margin-left: 15px;width:230px'];
        $aSelectLabel = sprintf(
            '%1$s <a href="%3$s" title="%2$s""><img src="%4$s" alt="%2$s"></a>',
            $GLOBALS['strUseWyswygHtmlEditor'],
            $GLOBALS['strChangeDefault'],
            htmlspecialchars(MAX::constructURL(MAX_URL_ADMIN, 'account-preferences-user-interface.php')),
            htmlspecialchars(MAX::constructURL(MAX_URL_ADMIN, 'assets/images/help-book.gif'))
        );
        $htmlG['tinyMCE'] = $form->createElement('checkbox', 'tinymce', $aSelectLabel, '', ['id' => 'tinymce', 'onclick' => "rv_tinymce('#htmltemplate', this.checked, {$imgUrlPrefixJs})"]);
        $htmlG['select'] = $form->createElement('select', 'adserver', $GLOBALS['strAlterHTML'], $adPluginsList, $aSelectAttributes);
        $htmlG['js'] = $form->createElement(
            'html',
            '',
            <<<EOF
<script>
jQuery(function() {
    rv_tinymce("#htmltemplate", jQuery('#tinymce')[0].checked, {$imgUrlPrefixJs});
});
</script>
EOF
        );
        $form->addGroup($htmlG, 'html_banner_g', null, ["<br>", "<br><br>", ''], false);

        $form->addElement('advcheckbox', 'iframe_friendly', $GLOBALS['strIframeFriendly']);

        if ($row['bannerid'] && ($row['url'] || $row['target'])) {
            // The "url" and "target" elements remain as part of the form definition
            // for HTML banners only for existing banners that have either
            // url or target already set.
            $form->addElement('header', 'header_b_links', "Banner link");
            $form->addElement('text', 'url', $GLOBALS['strURL']);
            $form->addElement('text', 'target', $GLOBALS['strTarget']);
        }

        $form->addElement('header', 'header_b_display', 'Banner display');
        $sizeG['width'] = $form->createElement('text', 'width', $GLOBALS['strWidth'] . ":");
        $sizeG['width']->setSize(5);
        $sizeG['height'] = $form->createElement('text', 'height', $GLOBALS['strHeight'] . ":");
        $sizeG['height']->setSize(5);

        if (!empty($row['bannerid'])) {
            $sizeG['height']->setAttribute('onChange', 'oa_sizeChangeUpdateMessage("warning_change_banner_size");');
            $sizeG['width']->setAttribute('onChange', 'oa_sizeChangeUpdateMessage("warning_change_banner_size");');
        }
        $form->addGroup($sizeG, 'size', $GLOBALS['strSize'], "&nbsp;", false);

        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());

        //validation rules
        $translation = new OX_Translation();
        $widthRequiredRule = [$translation->translate($GLOBALS['strXRequiredField'], [$GLOBALS['strWidth']]), 'required'];
        $heightRequiredRule = [$translation->translate($GLOBALS['strXRequiredField'], [$GLOBALS['strHeight']]), 'required'];
        $numericRule = [$GLOBALS['strNumericField'], 'numeric'];

        $form->addGroupRule('size', [
            'width' => [$widthRequiredRule, $numericRule],
            'height' => [$heightRequiredRule, $numericRule]]);

        $form->setDefaults([
            'tinymce' => $useTinyMCE,
        ]);
    }

    public function preprocessForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        return true;
    }

    public function processForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        return true;
    }

    public function validateForm(&$form)
    {
        return true;
    }

    public function buildHtmlTemplate($aFields)
    {
    }

    /**
     * Modify the generated banner cache.
     *
     * @param string $buffer the banner cache.
     * @param array $noScript
     * @param array $banner
     * @return string
     */
    public function getBannerCache($buffer, &$noScript, $banner)
    {
        return $buffer;
    }
}
