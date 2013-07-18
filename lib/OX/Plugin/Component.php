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

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once LIB_PATH . '/Translation.php';

define('OX_COMPONENT_SUFFIX', '.class.php');

/**
 * OX_Component is a static helper class for dealing with plugins/components. It
 * provides a factory method for including/instantiating components, and
 * provides methods for:
 *  - Reading groups of components from an extension or from an extension/group;
 *  - Calling component methods;
 *
 * Note: This class was taken from lib/max/Plugin.php
 *
 * @static
 * @package    OpenXPlugin
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Radek Maciaszek <radek@openx.org>
 */
class OX_Component
{
    var $extension;
    var $group;
    var $component;
    var $enabled;

    var $oTrans;

    /**
     * A factory method, for including and instantiating a component, given an
     * extension/group (and optional component name).
     *
     * @static
     * @param string $extension The plugin extension name (i.e. /plugins/<extension> directory).
     * @param string $group The component group name (i.e. /plugins/<extension>/<group> directory).
     * @param string $component Optional name of the PHP file which contains the component,
     *                     otherwise the component with the same name as the group is assumed.
     * @todo There is currently a mechanism in place to not include components from groups which
     *       haven't been enabled in the configuration file, as more extensions are refactored,
     *       they should be added to the refactoredExtensions until this whole section can be removed
     * @return mixed The instantiated component object, or false on error.
     */
    function factory($extension, $group, $component = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($component === null) {
            $component = $group;
        }
        if (!self::_includeComponentFile($extension, $group, $component))
        {
            return false;
        }
        $className = self::_getComponentClassName($extension, $group, $component);
        $obj = new $className($extension, $group, $component);
        $obj->extension = $extension;
        $obj->group     = $group;
        $obj->component = $component;
        $obj->enabled   = self::_isGroupEnabled($group, $extension);
        $obj->oTrans = new OX_Translation($aConf['pluginPaths']['packages'] . $group . '/_lang');

        return $obj;
    }

    function factoryByComponentIdentifier($componentIdentifier)
    {
        $aParts = self::parseComponentIdentifier($componentIdentifier);
        if (!$aParts) {
            return false;
        }
        $returned = call_user_func_array(array('OX_Component', 'factory'), $aParts);
        return $returned;
    }

    function _isGroupInstalled($group)
    {
        return isset($GLOBALS['_MAX']['CONF']['pluginGroupComponents'][$group]);
    }

    function _isGroupEnabled($group)
    {
        return ( self::_isGroupInstalled($group) && $GLOBALS['_MAX']['CONF']['pluginGroupComponents'][$group] ? true : false);
    }

    /**
     * A private method to include a component class file, given an extension/group
     * (and optional component name).
     *
     * @static
     * @access private
     * @param string $extension The plugin extension (i.e. /plugins/<extension> directory).
     * @param string $group The component group name (i.e. /plugins/<extension>/<group> directory).
     * @param string $component Optional name of the PHP file which contains the component,
     *                     otherwise the component with the same name as the group is assumed.
     * @return boolean True on success, false otherwise.
     */
    function _includeComponentFile($extension, $group, $component = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($component === null) {
            $component = $group;
        }
        if ($extension == 'admin')
        {
            $fileName = MAX_PATH . $aConf['pluginPaths']['admin'] . $group . "/".  $group . OX_COMPONENT_SUFFIX;
        }
        else
        {
            $groupPath = empty($group) ? "" : $group."/";

            $fileName = MAX_PATH . $aConf['pluginPaths']['plugins'] . $extension . "/". $groupPath . $component . OX_COMPONENT_SUFFIX;
        }
        if (!file_exists($fileName))
        {
            //MAX::raiseError("Unable to include the file $fileName.");
            return false;
        }
        include_once $fileName;
        $className = self::_getComponentClassName($extension, $group, $component);
        if (!class_exists($className)) {
            //MAX::raiseError("Component file included but class '$className' does not exist.");
            return false;
        } else {
            return true;
        }
    }

    /**
     * A private method for generating the (expected) class name of a component.
     *
     * @static
     * @access private
     * @param string $extension The plugin extension name (i.e. /plugins/<extension> directory).
     * @param string $group The component group name (i.e. /plugins/<extension>/<group> directory).
     * @param string $component Optional name of the PHP file which contains the component,
     *                     otherwise the component with the same name as the group
     *                     is assumed.
     * @return string The component class name.
     */
    function _getComponentClassName($extension, $group, $component = null)
    {
        if ($component === null) {
            $component = $group;
        }
        $className = 'Plugins_' . ucfirst($extension) . '_' . ucfirst($group) . '_' . ucfirst($component);
        return $className;
    }

    /**
     * A method to return an array of component objects from a selected plugin extension
     * or extension/group.
     *
     * @static
     * @param string $extension The plugin extension name (i.e. /plugins/<extension> directory).
     * @param string $group An optional component group name (i.e. /plugins/<extension>/<group>
     *                        directory). If not given, the search for component files will start
     *                        at the extension directory level.
     * @param mixed $recursive If the boolean 'true', returns all components in the
     *                         given extension (and group, if specified), and all
     *                         subdirectories thereof.
     *                         If an integer, returns all components in the given
     *                         extension (and group, if specified) and subdirectories
     *                         thereof, down to the depth specified by the parameter.
     * @param boolean $enabledOnly Only return components which are contained in plugins
     *                             which are enabled.
     * @return array An array of component objects, indexed by component identifier.
     */
    function &getComponents($extension, $group = null, $recursive = 1, $enabledOnly = true)
    {
        $aComponents = array();
        $aGroups = self::_getComponentsFiles($extension, $group, $recursive);
        if (is_array($aGroups)) {
            foreach ($aGroups as $group => $aComponentFiles)
            {
                if (self::_isGroupInstalled($group))
                {
                    foreach ($aComponentFiles as $i => $file)
                    {
                        $component = str_replace(OX_COMPONENT_SUFFIX, '', $file);
                        $oComponent = self::factory($extension, $group, $component);
                        if ($oComponent !== false && (!$enabledOnly || $oComponent->enabled == true))
                        {
                            $aComponents[$oComponent->getComponentIdentifier()] = $oComponent;
                        }
                    }
                }
            }
        }
        return $aComponents;
    }

    /**
     * A private method to return a list of component files in a given plugin extension,
     * or a given extension/group.
     *
     * @static
     * @access private
     * @param string $extension The plugin extension name (i.e. /plugins/<extension> directory).
     * @param string $group An optional component group name (i.e. /plugins/<extension>/<group>
     *                        directory). If not given, the search for component files will
     *                        start at the extension directory level.
     * @param mixed $recursive If the boolean 'true', returns all component files in the
     *                         given directory and all subdirectories.
     *                         If an integer, returns all component files in the given
     *                         directory and subdirectories down to the depth
     *                         specified by the parameter.
     * @return array An array of the component files found, indexed by "directory:filename",
     *               where "directory" is the relative directory path below the
     *               given directory parameter, and "filename" is the filename
     *               before the OX_COMPONENT_SUFFIX extension of the file.
     */
    function _getComponentsFiles($extension, $group = null, $recursive = 1)
    {
        $aResult = array();
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($extension != 'admin')
        {
            $pathExtension = $aConf['pluginPaths']['plugins'] . $extension . '/';
        }
        else
        {
            $pathExtension = $aConf['pluginPaths']['admin'];
            $recursive = false;
        }
        if (!empty($group))
        {
            $aGroups[] = $group;
        }
        else
        {
        	$aGroups = self::_getComponentGroupsFromDirectory(MAX_PATH.$pathExtension);
        }
        foreach ($aGroups as $i => $group)
        {
            $aMatches = array();
            $aFiles = self::_getComponentFilesFromDirectory(MAX_PATH.$pathExtension.$group, $recursive, $aMatches);
            if (count($aFiles))
            {
                $aResult[$group] = $aFiles;
            }
        }
        return $aResult;
    }

    function _getComponentGroupsFromDirectory($directory)
    {
        $aGroups = array();
        if (is_readable($directory))
        {
            if ($aFiles = scandir($directory))
            {
                foreach ($aFiles as $i => $name)
                {
                    if (substr($name, 0, 1) == '.')
                    {
                        continue;
                    }
                    if (is_dir($directory.$name))
                    {
                        $aGroups[] = $name;
                    }
                }
            }
        }
        return $aGroups;
    }

    /**
     * A private method to return a list list of files from a directory
     * (and subdirectories, if appropriate)  which match the defined
     * plugin file mask (MAX_PLUGINS_FILE_MASK).
     *
     * @static
     * @access private
     * @param string $directory The directory to search for files in.
     * @param mixed $recursive If the boolean 'true', returns all files in the given
     *                         directory and all subdirectories that match the file
     *                         mask.
     *                         If an integer, returns all files in the given
     *                         directory and subdirectories down to the depth
     *                         specified by the parameter that match the file mask.
     * @return array An array of the files found, indexed by "directory:filename",
     *               where "directory" is the relative directory path below the
     *               given directory parameter, and "filename" is the filename
     *               before the OX_COMPONENT_SUFFIX extension of the file.
     */
    function _getComponentFilesFromDirectory($directory, $recursive = 1, &$aMatches)
    {
        if (is_readable($directory))
        {
            $fileMask = '/([\w\W\d]+)'.preg_quote(OX_COMPONENT_SUFFIX).'/';
            if ($aFiles = scandir($directory))
            {
                $aMatches = array_merge($aMatches, preg_grep($fileMask, $aFiles));
                if ($recursive)
                {
                    foreach ($aFiles as $i => $name)
                    {
                        if (substr($name, 0, 1) == '.')
                        {
                            continue;
                        }
                        if (is_dir($directory.DIRECTORY_SEPARATOR.$name))
                        {
                            self::_getComponentFilesFromDirectory($directory.DIRECTORY_SEPARATOR.$name, $recursive, $aMatches);
                        }
                    }
                }
            }
        }
        return $aMatches;
    }

    /**
     * A method to include a component, and call a method statically on the component class.
     *
     * @static
     * @param string $extension The plugin extension name (i.e. /plugins/<extension> directory).
     * @param string $group The plugin package name (i.e. /plugins/<extension>/<group>
     *                        directory).
     * @param string $component Optional name of the PHP file which contains the component class,
     *                     otherwise the component with the same name as the group
     *                     is assumed.
     * @param string $staticMethod The name of the method of the component class to call statically.
     * @param array $aParams An optional array of parameters to pass to the method called.
     * @return mixed The result of the static method call, or false on failure to include
     *               the plugin.
     */
    function &callStaticMethod($extension, $group, $component = null, $staticMethod, $aParams = null)
    {
        if ($component === null) {
            $component = $group;
        }
        if (!self::_isGroupEnabled($group, $extension))
        {
            return false;
        }
        if (!self::_includeComponentFile($extension, $group, $component)) {
            return false;
        }
        $className = self::_getComponentClassName($extension, $group, $component);

        // PHP4/5 compatibility for get_class_methods.
        $aClassMethods = array_map(strtolower, (get_class_methods($className)));
        if (!$aClassMethods) {
            $aClassMethods = array();
        }
        if (!in_array(strtolower($staticMethod), $aClassMethods)) {
            MAX::raiseError("Method '$staticMethod()' not defined in class '$className'.", MAX_ERROR_INVALIDARGS);
            return false;
        }
        if (!isset($aParams)) {
            return call_user_func(array($className, $staticMethod));
        } else {
            if (!is_array($aParams)) {
                $aParams = array($aParams);
            }
            return call_user_func_array(array($className, $staticMethod), $aParams);
        }
    }

    /**
     * A method to run a method on all component objects in an array of components.
     *
     * @static
     * @param array $aComponents An array of component objects.
     * @param string $methodName The name of the method to executed for every component.
     * @param array $aParams An optional array of parameters to pass to the method called.
     * @return mixed An array of the results of the method calls, or false on error.
     */
    function &callOnComponents(&$aComponents, $methodName, $aParams = null)
    {
        if (!is_array($aComponents)) {
            MAX::raiseError('Bad argument: Not an array of components.', MAX_ERROR_INVALIDARGS);
            return false;
        }
        foreach ($aComponents as $key => $oComponent) {
            if (!is_a($oComponent, 'OX_Component')) {
                MAX::raiseError('Bad argument: Not an array of components.', MAX_ERROR_INVALIDARGS);
                return false;
            }
        }
        $aReturn = array();
        foreach ($aComponents as $key => $oComponent) {
            // Check that the method name can be called
            if (!is_callable(array($oComponent, $methodName))) {
                $message = "Method '$methodName()' not defined in class '" .
                            self::_getComponentClassName($oComponent->extension, $oComponent->group, $oComponent->component) . "'.";
                MAX::raiseError($message, MAX_ERROR_INVALIDARGS);
                return false;
            }
            if (is_null($aParams)) {
                $aReturn[$key] = call_user_func(array($aComponents[$key], $methodName));
            } else {
                $aReturn[$key] = call_user_func_array(array($aComponents[$key], $methodName), $aParams);
            }
        }
        return $aReturn;
    }

    function getListOfRegisteredComponentsForHook($hook)
    {
        $aHooks = self::getComponentsHookCache();
        if (isset($aHooks[$hook]))
        {
            return $aHooks[$hook];
        }
        return array();
    }

    function getComponentsHookCache()
    {
        if (!isset($GLOBALS['_MAX']['ComponentHooks']))
        {
            $oCache = new OA_Cache('Plugins', 'ComponentHooks');
            $oCache->setFileNameProtection(false);
            $GLOBALS['_MAX']['ComponentHooks'] = $oCache->load(true);
            if ($GLOBALS['_MAX']['ComponentHooks'] === false)
            {
                require_once LIB_PATH . '/Plugin/PluginManager.php';
                $oPluginManager = new OX_PluginManager();
                $GLOBALS['_MAX']['ComponentHooks'] = $oPluginManager->getComponentHooks();
                $oCache->save($GLOBALS['_MAX']['ComponentHooks']);
            }
        }
        return $GLOBALS['_MAX']['ComponentHooks'];
    }

    function getComponentIdentifier()
    {
        return implode(':', array($this->extension, $this->group, $this->component));
    }

    /**
     * Parse a colon separated component identifier, returning
     * its parts in an array.
     *
     * @param string $componentIdentifier
     * @return mixed An array on success, or a PEAR error otherwise
     */
    function parseComponentIdentifier($componentIdentifier)
    {
        if (!preg_match('/^([a-zA-Z0-9]+):([a-zA-Z0-9]+)(?::([a-zA-Z0-9]+))?$/D', $componentIdentifier, $m)) {
            return false;
        }
        array_shift($m);
        return array_values($m);
    }

    /**
     * This method gets the handler that should be used for a particulat extension if the component
     * doesn't provide it's own specific handler
     *
     * @param string $extension The extension to get the fallback handler for
     * @return object The handler object
     */
    function &getFallbackHandler($extension)
    {
        //$path = $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'].$extension.'/';
        $fileName = LIB_PATH.'/Extension/'.$extension.'/'.$extension.'.php';
        if (!file_exists($fileName))
        {
            MAX::raiseError("Unable to include the file $fileName.");
            return false;
        }
        include_once $fileName;
        $className  = 'Plugins_'.$extension;
        if (!class_exists($className))
        {
            MAX::raiseError("Plugin file included but class '$className' does not exist.");
            return false;
        }
        $oPlugin = new $className();
        $oPlugin->extension = $extension;
        $oPlugin->enabled   = false;
        return $oPlugin;
    }

    function translate($string, $aValues = array(), $pluralVar = false)
    {
        return $this->oTrans->translate($string, $aValues, $pluralVar);
    }

    /**
     * This method is executed when this component is enabled
     *
     * @return boolean The result of the attempt to enable this component
     */
    function onEnable()
    {
        return true;
    }

    /**
     * This method is executed when this component is enabled
     *
     * @return boolean The result of the attempt to disable this component
     */
    function onDisable()
    {
        return true;
    }
    
    function getName()
    {
        return $this->getComponentIdentifier();
    }
}

?>
