<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
/**
 * OpenX Developer Toolbox
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 * $Id$
 *
 */

function getExtensionList()
{
    require_once(LIB_PATH.'/Extension.php');
    return OX_Extension::getAllExtensionsArray();
}

class OX_PluginBuilder_Common
{

    var $aTemplates;
    var $aValues;

    var $aRegPattern;
    var $aRegReplace;

    var $pathPlugin;

    function init($aVals)
    {
        global $pathPlugin;

        $this->pathPlugin = $pathPlugin;

        $this->aValues = $aVals;

        $this->aTemplates['HEADER']     = 'header.xml.tpl';
        $this->aTemplates['FILES']      = 'files.xml.tpl';

        foreach ($aVals AS $k => $v)
        {
            $this->aRegPattern[] = '/\{'.strtoupper($k).'\}/';
            $this->aRegReplace[] = $v;
        }
    }

    function _compileTemplate($tag, &$data)
    {
        if (!array_key_exists($tag, $this->aTemplates))
        {
            $data = str_replace('{'.strtoupper($tag).'}', '', $data);
            return;
        }
        if (!file_exists('etc/elements/'.$aTemplates[$tag]))
        {
            return;
        }
        $dataSource = file_get_contents('etc/elements/'.$this->aTemplates[$tag]);
        if (!$dataSource)
        {
            return;
        }
        $this->_replaceTags($dataSource);
        $data = str_replace('{'.strtoupper($tag).'}', $dataSource, $data);
    }

    function _replaceTags(&$subject)
    {
        $result = preg_replace(array_values($this->aRegPattern),array_values($this->aRegReplace), $subject);
        $subject = ($result ? $result : $subject);
        return;
    }

    function _renameFile($needle, $file)
    {
        if (substr_count($file, $needle))
        {
            copy($file, str_replace($needle, $this->aValues[$needle], $file));
            unlink($file);
        }
    }

    function _compileFiles($dir, $replace='')
    {
        $dh = opendir($dir);
        if ($dh)
        {
            while (false !== ($file = readdir($dh)))
            {
                if (substr($file, 0, 1) != '.')
                {
                    if (is_dir($dir.'/'.$file))
                    {
                        $this->_compileFiles($dir.'/'.$file, $replace);
                    }
                    else
                    {
                        $contents = file_get_contents($dir.'/'.$file);
                        $this->_replaceTags($contents);
                        $i = file_put_contents($dir.'/'.$file, $contents);
                        if ($replace)
                        {
                            $this->_renameFile($replace, $dir.'/'.$file);
                        }
                    }
                }
            }
            closedir($dh);
        }
    }

}

class OX_PluginBuilder_Group extends OX_PluginBuilder_Common
{
    var $pathGroup;
    var $schema = false;

    function init($aVals)
    {
        parent::init($aVals);

        $file = 'files-'.$this->aValues['extension'].'.xml.tpl';
        if (file_exists('etc/elements/'.$file))
        {
            $this->aTemplates['FILES'] = $file;
        }
        if ($aVals['extension']=='admin')
        {
            $this->aTemplates['NAVIGATION'] = 'navigation.xml.tpl';
        }
        if ($this->schema)
        {
            $this->aTemplates['SCHEMA'] = 'schema.xml.tpl';
        }

        global $pathPackages;
        $this->pathGroup = $pathPackages.$aVals['group'].'/';

    }

    function putGroup()
    {
        $groupDefinitionFile = $this->pathGroup.'group.xml';

        $dataTarget = file_get_contents($groupDefinitionFile);

        $this->_compileTemplate('HEADER', $dataTarget);
        $this->_compileTemplate('FILES', $dataTarget);
        $this->_compileTemplate('NAVIGATION', $dataTarget);
        $this->_compileTemplate('SCHEMA', $dataTarget);
        $i = file_put_contents($groupDefinitionFile, $dataTarget);

        copy($groupDefinitionFile, str_replace('group',$this->aValues['name'], $groupDefinitionFile));
        unlink($groupDefinitionFile);
        $this->_compileFiles($this->pathPlugin, 'group');
    }
}

class OX_PluginBuilder_Package extends OX_PluginBuilder_Common
{
    var $pathPackages;

    function init($aVals)
    {
        parent::init($aVals);

        global $pathPackages;
        $this->pathPackages = $pathPackages;
    }

    function putPlugin()
    {
        $pluginDefinitionFile = $this->pathPackages.'plugin.xml';
        $data = file_get_contents($pluginDefinitionFile);
        $this->_compileTemplate('HEADER', $data);

        $groups ='';
        foreach ($this->aValues['grouporder'] as $i => $group)
        {
            $groups.= "            <group name=\"{$group}\">{$i}</group>\n";
        }
        $data = str_replace('{GROUPS}', $groups, $data);
        $data = str_replace('{NAME}', $this->aValues['name'], $data);
        $i = file_put_contents($pluginDefinitionFile, $data);

        copy($pluginDefinitionFile, str_replace('plugin',$this->aValues['name'], $pluginDefinitionFile));
        unlink($pluginDefinitionFile);

        $pluginReadmeFile = $this->pathPackages.'plugin.readme.txt';
        copy($pluginReadmeFile, str_replace('plugin',$this->aValues['name'], $pluginReadmeFile));
        unlink($pluginReadmeFile);
    }
}

?>
