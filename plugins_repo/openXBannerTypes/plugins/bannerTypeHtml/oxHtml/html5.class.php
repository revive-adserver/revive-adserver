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
require_once LIB_PATH . '/Extension/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 * @abstract
 */
class Plugins_BannerTypeHTML_oxHtml_html5 extends Plugins_BannerTypeHTML
{
    /**
     * @var \RV\Manager\Html5ZipManager
     */
    private $manager;

    /**
     * Return type of plugin
     *
     * @return string A string describing the type of plugin.
     */
    public function getOptionDescription()
    {
        return $this->translate("HTML5 Banner (ZIP package)");
    }

    /**
     * @param HTML_QuickForm $form
     * @param array $row
     */
    public function buildForm(&$form, &$row)
    {
        if (!empty($row['parameters'])) {
            $parameters = unserialize($row['parameters']);
            if (is_array($parameters)) {
                $row += $parameters;
            }
        }

        $header = $form->createElement('header', 'header_html', $this->translate("Upload an HTML5 banner"));
        $header->setAttribute('icon', 'icon-banner-html5.gif');
        $form->addElement($header);

        $row['filename'] = '';

        addUploadGroup(
            $form,
            $row,
            [
                'uploadName' => 'html5zip',
                'radioName' => 'rhtml5zip',
                'imageName' => _getContentTypeIconImageName('html'),
                'fileName' => isset($row['html5_name']) ? $row['html5_name'] : '',
                'fileSize' => isset($row['html5_size']) ? _getPrettySize($row['html5_size']) : '',
                'newLabel' => $GLOBALS['strNewBannerFile'],
                'updateLabel' => $GLOBALS['strUploadOrKeep'],
            ]
        );

        $form->addElement('header', 'header_b_links', "Banner link");
        $form->addElement('text', 'url', $GLOBALS['strURL']);

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

        // Validation rules
        $numericRule = [$GLOBALS['strNumericField'], 'numeric'];
        $form->addGroupRule('size', [
            'width' => [$numericRule],
            'height' => [$numericRule],
        ]);

        $form->addFormRule([$this, 'checkNewUploadedFile']);
    }

    /**
     * Quickform form validation rule.
     *
     * @param array $aFields
     *
     * @return array|bool
     */
    public function checkNewUploadedFile($aFields)
    {
        if (!empty($_FILES['html5zip']) && !empty($_FILES['html5zip']['size']) && $aFields['rhtml5zip'] == 't') {
            try {
                $this->manager = RV_getContainer()->get('html5.zip.manager');
                $this->manager->open($_FILES['html5zip']['tmp_name']);
            } catch (\Exception $e) {
                return [
                    'html5zip_group' => $e->getMessage(),
                ];
            }
        }

        return true;
    }

    public function preprocessForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        if (null !== $this->manager) {
            $aVariables['width'] = $this->manager->getWidth() ?: $aFields['width'];
            $aVariables['height'] = $this->manager->getHeight() ?: $aFields['height'];

            $aVariables['filename'] = $this->manager->copyToWebdir();

            $aVariables['parameters'] = serialize([
                'html5_name' => $_FILES['html5zip']['name'],
                'html5_size' => $_FILES['html5zip']['size'],
            ]);
        }

        $aVariables['content_type'] = 'html';
        $aVariables['adserver'] = 'none';
        $aVariables['iframe_friendly'] = false;

        return true;
    }
}
