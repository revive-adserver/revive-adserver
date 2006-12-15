<?php

class HTML_Template_Flexy_Compiler_Regex {
        
    /**
    * The main flexy engine
    *
    * @var object HTML_Template_Flexy
    * @access public
    */
    
    var $flexy;
    /**
    *   classicParse - the older regex based code generator.
    *   here all the replacing, filtering and writing of the compiled file is done
    *   well this is not much work, but still its in here :-)
    *
    *   @access     private
    *   @version    01/12/03
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @author     Alan Knowles <alan@akbkhome.com>
    *   @return   boolean (basically true all the time here)
    */
    function compile(&$flexy)
    {
        $this->flexy = &$flexy;
        // read the entire file into one variable
        $fileContent = file_get_contents($flexy->currentTemplate);
         
        //  apply pre filter
        $fileContent = $this->applyFilters( $fileContent , "/^pre_/i" );
        $fileContent = $this->applyFilters( $fileContent , "/^(pre_|post_)/i",TRUE);
        $fileContent = $this->applyFilters( $fileContent , "/^post_/i" );
        // write the compiled template into the compiledTemplate-File
        if( ($cfp = fopen( $flexy->compiledTemplate , 'w' )) ) {
            fwrite($cfp,$fileContent);
            fclose($cfp);
            @chmod($flexy->compiledTemplate,0775);
        }

        return true;
    }
    /**
    *   actually it will only be used to apply the pre and post filters
    *
    *   @access     public
    *   @version    01/12/10
    *   @author     Alan Knowles <alan@akbkhome.com>
    *   @param      string  $input      the string to filter
    *   @param      array   $prefix     the subset of methods to use.
    *   @return     string  the filtered string
    */
    function applyFilters( $input , $prefix = "",$negate=FALSE)
    {
        $this->flexy->debug("APPLY FILTER $prefix<BR>");
        $filters = $this->options['filters'];
        $this->flexy->debug(serialize($filters)."<BR>");
        foreach($filters as $filtername) {
            $class = "HTML_Template_Flexy_Compiler_Regex_{$filtername}";
            require_once("HTML/Template/Flexy/Compiler/Regex/{$filtername}.php");
            
            if (!class_exists($class)) {
                return HTML_Template_Flexy::raiseError("Failed to load filter $filter",null,HTML_TEMPLATE_FLEXY_ERROR_DIE);
            }
            
            if (!@$this->filter_objects[$class])  {
                $this->filter_objects[$class] = new $class;
                $this->filter_objects[$class]->_set_engine($this);
            }
            $filter = &$this->filter_objects[$class];
            $methods = get_class_methods($class);
            $this->flexy->debug("METHODS:");
            $this->flexy->debug(serialize($methods)."<BR>");
            foreach($methods as $method) {
                if ($method{0} == "_") {
                    continue; // private
                }
                if ($method  == $class) {
                    continue; // constructor
                }
                $this->flexy->debug("TEST: $negate $prefix : $method");
                if ($negate &&  preg_match($prefix,$method)) {
                    continue;
                }
                if (!$negate && !preg_match($prefix,$method)) {
                    continue;
                }
                
                $this->flexy->debug("APPLYING $filtername $method<BR>");
                $input = $filter->$method($input);
            }
        }

        return $input;
    }
}


