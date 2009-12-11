<?php
require_once SMARTY_LIB_PATH.'/Smarty_Compiler.class.php';

/**
 * A customized Smarty compilers that knows how to compile the shorthands for calling ZF
 * view helpers from smarty templates.
 */
class OX_UI_Smarty_SmartyCompilerWithViewHelper extends Smarty_Compiler
{


    public function __construct()
    {
        parent::__construct();
    }


    function _compile_compiler_tag($tagCommand, $tagArgs, &$output)
    {
        // We first try to use Smarty's own functionality to parse the tag
        $found = parent::_compile_compiler_tag($tagCommand, $tagArgs, $output);
        
        // There is no easy access to the list of Smarty's built-in functions
        // so we need to list them here. HTML-specific functions are not included
        // as we cover HTML generation separately.
        $smartyBuiltInFunctions = array (
                'assign', 'counter', 
                'cycle', 'debug', 
                'eval', 'fetch', 
                'mailto', 'math', 
                'popup', 
                'popup_init', 
                'textformat');
        
        // Check for Smarty's built-in functions
        if (!$found && !in_array($tagCommand, $smartyBuiltInFunctions) && !key_exists($tagCommand, $this->_plugins['function'])) {
            $helperArgs = array ();
            $method = '';
            
            if ($tagArgs !== null) {
                // Start parsing our custom syntax
                $params = $this->_parse_attrs_customized($tagArgs);
                foreach ($params as $key => $value) {
                    // Split each key=value pair to vars
                    $section = '';
                    
                    // Check for the _method special parameter
                    if ($key == '_method') {
                        $method = "->" . preg_replace('/[\'"]/', '', $value);
                        continue;
                    }
                    
                    // If there's a dot in the key, it means we
                    // need to use associative arrays
                    if (strpos($key, '.') !== false) {
                        list ($key, $section) = explode('.', $key);
                    }
                    
                    // Put the value into the arg array
                    $this->addToMultimap($helperArgs, $key, $value, $section);
                }
            }
            
            // Save the code to put to the template in the output
            $output = "<?php echo \$this->callViewHelper('$tagCommand', " . $this->_createParameterCode($helperArgs) . ")" . $method . "; ?>";
            $found = true;
        }
        
        return $found;
    }


    /**
     * There is no easy way to have Smarty parse our customized attribute syntax,
     * so we need to copy the whole implementation and tweak it a bit. Changes are marked
     * with "OX_CUSTOM:" string.
     */
    function _parse_attrs_customized($tag_args)
    {
        /* Tokenize tag attributes. */
        $match = array();
        preg_match_all('~(?:' . $this->_obj_call_regexp . '|' . $this->_qstr_regexp . ' | (?>[^"\'=\s]+)
                         )+ |
                         [=]
                        ~x', $tag_args, $match);
        $tokens = $match[0];
        
        $attrs = array ();
        /* Parse state:
            0 - expecting attribute name
            1 - expecting '='
            2 - expecting attribute value (not '=') */
        $state = 0;
        
        foreach ($tokens as $token) {
            switch ($state) {
                case 0:
                    /* If the token is a valid identifier, we set attribute name
                       and go to state 1. */
                    // OX_CUSTOM: added '.' to the allowed content of attribute name
                    // as these are contained in our customized attribute syntax.
                    if (preg_match('~^(\w|\.)+$~', $token)) {
                        $attr_name = $token;
                        $state = 1;
                    }
                    else
                        $this->_syntax_error("invalid attribute name: '$token'", E_USER_ERROR, __FILE__, __LINE__);
                    break;
                
                case 1:
                    /* If the token is '=', then we go to state 2. */
                    if ($token == '=') {
                        $state = 2;
                    }
                    else
                        $this->_syntax_error("expecting '=' after attribute name '$last_token'", E_USER_ERROR, __FILE__, __LINE__);
                    break;
                
                case 2:
                    /* If token is not '=', we set the attribute value and go to
                       state 0. */
                    if ($token != '=') {
                        /* We booleanize the token if it's a non-quoted possible
                           boolean value. */
                        if (preg_match('~^(on|yes|true)$~', $token)) {
                            $token = 'true';
                        }
                        else 
                            if (preg_match('~^(off|no|false)$~', $token)) {
                                $token = 'false';
                            }
                            else 
                                if ($token == 'null') {
                                    $token = 'null';
                                }
                                else 
                                    if (preg_match('~^' . $this->_num_const_regexp . '|0[xX][0-9a-fA-F]+$~', $token)) {
                                        /* treat integer literally */
                                    }
                                    else 
                                        if (!preg_match('~^' . $this->_obj_call_regexp . '|' . $this->_var_regexp . '(?:' . $this->_mod_regexp . ')*$~', $token)) {
                                            /* treat as a string, double-quote it escaping quotes */
                                            $token = '"' . addslashes($token) . '"';
                                        }
                        
                        // OX_CUSTOM: conflate multiple values for one key into arrays.
                        // Perform Smarty's resolution of values here.
                        $this->addToMultimap($attrs, $attr_name, parent::_parse_var_props($token));
                        $state = 0;
                    }
                    else
                        $this->_syntax_error("'=' cannot be an attribute value", E_USER_ERROR, __FILE__, __LINE__);
                    break;
            }
            $last_token = $token;
        }
        
        if ($state != 0) {
            if ($state == 1) {
                $this->_syntax_error("expecting '=' after attribute name '$last_token'", E_USER_ERROR, __FILE__, __LINE__);
            }
            else {
                $this->_syntax_error("missing attribute value", E_USER_ERROR, __FILE__, __LINE__);
            }
        }
        
        // OX_CUSTOM: moved the _parse_var_props call from here to state 2 above
        
        return $attrs;
    }


    private function addToMultimap(&$helperArgs, $key, $value, $section = '')
    {
        if ($section == '') {
            if (array_key_exists($key, $helperArgs)) {
                if (is_array($helperArgs[$key])) {
                    $helperArgs[$key][] = $value;
                }
                else {
                    $helperArgs[$key] = array (
                            $helperArgs[$key], 
                            $value);
                }
            }
            else {
                $helperArgs[$key] = $value;
            }
        }
        else {
            if (!isset($helperArgs[$key]) || !is_array($helperArgs[$key])) {
                $helperArgs[$key] = array ();
            }
            
            $helperArgs[$key][$section] = $value;
        }
    }


    private function _createParameterCode($v)
    {
        $code = '';
        
        if (is_array($v)) {
            $code .= 'array(';
            
            $count = count($v);
            foreach ($v as $key => $arrayValue) {
                if (is_integer($key)) {
                    $keyCode = $key;
                }
                else {
                    $keyCode = "'" . $key . "'";
                }
                
                $code .= $keyCode . " => " . $this->_createParameterCode($arrayValue);
                if (--$count != 0) {
                    $code .= ', ';
                }
            }
            $code .= ')';
        
        }
        else {
            $code .= $v;
        }
        
        return $code;
    }
}

