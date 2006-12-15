<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors:  nobody <nobody@localhost>                                  |
// +----------------------------------------------------------------------+
//
// $Id: Translator.php,v 1.5 2004/07/26 04:39:24 alan_k Exp $
//
//  Controller Type Class providing translation faciliites
//
   
/*

usage : 

$t = new HTML_Template_Flexy_Translator(array(
    'baseLang'      => 'en',
    'targetLangs'   => array('es','fr','zh'),
    'appURL'       => '/admin/translate.php',

));
$t->process(isset($_GET ? $_GET : array(),isset($_POST ? $_POST : array()); // read data.. etc.
// you can replace this pretty easily with your own templates..
$t->outputDefautTemplate();

*/

class HTML_Template_Flexy_Translator {
    
    /**
    * Options for Translator tool.
    *
    * @var array
    * @access public 
    */
    var $options = array(
        'baseLang'          => 'en',            // the language the templates are in.
        'targetLangs'       => array('fr'),     // the language the templates are being translated to.
        'templateDir'       => '',              // these are read from global config if not set.
        'compileDir'        => '',        
        'url_rewrite'       => '',              // for image rewriting.. -- needs better thinking through!
        'appURL'            => '',              // url to translation too : eg. /admin/translator.php
    );
    /**
    * app URL (copied from above)
    *
    * @var string
    * @access public 
    */
    var $appURL;
    var $languages = array();
    /**
    * Array of templates and the words found in each one.
    *
    * @var array
    * @access public 
    */
    var $words= array();   
    /**
    * Array of objects with name, md5's, has it been set, the translation etc.
    *
    * @var array
    * @access public 
    */
    var $status = array();
    /**
    * The current language
    *
    * @var array
    * @access public 
    */
    var $translate = ''; // language being displayed /edited.
    
    
    /**
    * constructor
    *
    * Just set options (no checking done)
    * 
    * 
    * @param   array   see options array in file.
    * @return   none
    * @access   public
    */
  
    function HTML_Template_Flexy_Translator($options= array()) {
        foreach($options as $k=>$v) {
            $this->options[$k]  = $v;
        }
        if (!in_array($this->options['baseLang'], $this->options['targetLangs'])) {
            $this->options['targetLangs'][] = $this->options['baseLang'];
        }
        $o = PEAR::getStaticProperty('HTML_Template_Flexy','options');
        if (!strlen($this->options['templateDir'])) {
            $this->options['templateDir'] = $o['templateDir'];
        }
        if (!strlen($this->options['compileDir'])) {
            $this->options['compileDir'] = $o['compileDir'];
        }
        if (!strlen($this->options['url_rewrite'])) {
            $this->options['url_rewrite'] = $o['url_rewrite'];
        }
        $this->appURL = $this->options['appURL'];
        $this->languages = $this->options['targetLangs'];
    }
    
    
    /**
    * process the input 
    *
    * 
    * @param   array   $_GET; (translate = en)
    * @param   array   $_POST; (translate = en, en[{md5}] = translation)
    
    * @return   none
    * @access   public
    */
    
    
    function process($get,$post) {
        //DB_DataObject::debugLevel(1);
        
        $displayLang = isset($get['translate']) ? $get['translate'] : 
            (isset($post['translate']) ? $post['translate'] : false);
            
        if ($displayLang === false) {
          
            return;
        }
        require_once 'Translation2/Admin.php';
        $trd = &new Translation2_Admin('dataobjectsimple', 'translations' );
        //$trd->setDecoratedLang('en');
        foreach($this->options['targetLangs'] as $l) {
            $trd->createNewLang(array('lang_id'=>$l));
        }
        
        // back to parent if no language selected..
        
        if (!in_array($displayLang, $this->options['targetLangs'] )) {
            require_once 'PEAR.php';
            return PEAR::raiseError('Unknown Language :' .$displayLang);
        }
        
        $this->translate = $displayLang;
        
        
        if (isset($post['_apply'])) {
            $this->clearTemplateCache($displayLang);
             
        }
        $t = explode(' ',microtime()); $start= $t[0] + $t[1];
     
        require_once 'Translation2.php';
        $tr = &new Translation2('dataobjectsimple','translations');
        $tr->setLang($displayLang);
        
        //$suggestions = &new Translation2('dataobjectsimple','translations');
        //$suggestions->setLang($displayLang);
        
        $this->compileAll();
        
        //$tr->setPageID('test.html');
        // delete them after we have compiled them!!
        if (isset($post['_apply'])) {
            $this->clearTemplateCache($displayLang);
        }
        //DB_DataObject::debugLevel(1);
        $this->loadTranslations();
        $this->loadTranslations($displayLang);
        
        $all = array();
        foreach($this->words as $page=>$words) {
            $status[$page] = array();
            $tr->setPageID($page);
            // pages....
            
            foreach ($words as $word) {
            
                if (!trim(strlen($word))) { 
                    continue;
                }
                
                $md5 = md5($page.':'.$word);
                
                //$value = $tr->get($word);
                $value = $this->getTranslation($page,$word,$displayLang);
                // we posted something..
                if (isset($post[$displayLang][$md5])) {
                    $nval = get_magic_quotes_gpc() ? stripslashes($post[$displayLang][$md5]) : $post[$displayLang][$md5];
                    
                    if ($value != $nval) {
                    
                        $trd->add($word,$page,array($displayLang=>$nval));
                        $value = $nval;
                    }
                }
                
                if ($value == '') {
                    // try the old gettext...
                    if (isset($old[addslashes($word)])) {
                        $trd->add($word,$page,array($displayLang=>$old[addslashes($word)]));
                        $value = $old[addslashes($word)];
                    }
                
                
                }
                
                $add = new StdClass;
                 
                $add->from = $word;
                $add->to   = $value;
                if (!$add->to || ($add->from == $add->to)) {
                    $add->untranslated = true;
                    $add->suggest = implode(', ', $this->getSuggestions($word, $displayLang));
                    //$suggest = $suggestions->get($word);
                    //if ($suggest && ($suggest  != $word)) {
                    //    $add->suggest = $suggestions->get($word);
                    //}
                }

                $add->md5 = $md5;
                $add->short = (bool) (strlen($add->from) < 30);
                $status[$page][] = $add;
            
                 
            }
            
        }
        $t = explode(' ',microtime()); $total= $t[0] + $t[1] -  $start;
        //printf("Built All in %0.2fs<BR>",$total);
        $this->status = $status;
          
             
    
    }
    var $translations = array();
    var $translationMap = array();
   
    /**
    * LoadTranslations - load all the translations from the database
    * into $this->translations[{lang}][{id}] = $translation;
    *
    * 
    * @param   string       Language
    * @access   public
    */
    function loadTranslations ($lang= false) {
        $d = DB_DataObject::factory('translations');
        $d->lang = ($lang == false) ? '-' : $lang;
        $d->find();
        $this->translations[$d->lang] = array();
        while ($d->fetch()) {
            $this->translations[$d->lang][$d->string_id] = $d->translation;
            if ($lang == false) {
                $this->translationMap[$d->page][$d->translation] = $d->string_id;
            }
            // suggestions:?
            
        }
    }
    
    function getSuggestions($string,$lang) {
        $ids = array();
        //echo '<PRE>';print_r($this->translationMap);
        foreach($this->translationMap as $page=>$map) {
            if (isset($map[$string])) {
                $ids[] = $map[$string];
            }
        }
        //echo '<PRE>';print_r(array($string,$lang,$ids,$this->translations[$lang]));
        
        //exit;
        if (!$ids) {
            return array();
        }
        $ret = array();
        foreach($ids as $id) {
            if (isset($this->translations[$lang][$id])) {
                $ret[] = $this->translations[$lang][$id];
            }
        }
       // echo '<PRE>';print_r($ret);
        return $ret;
    }
    
    function getTranslation($page,$word,$lang)
    {
        
        if (!isset($this->translationMap[$page][$word])) {
            //echo "No string id for $page : $word\n";
            return false;
        }
        if (!isset($this->translations[$lang][$this->translationMap[$page][$word]])) {
        
            return false;
        }
        return $this->translations[$lang][$this->translationMap[$page][$word]];
    }
    /**
    * compile all the templates in a specified folder.
    *
    * 
    * @param   string   subdirectory of templateDir or empty
    * @return   none
    * @access   public
    */

    function compileAll($d='') {
        set_time_limit(0); // this could take quite a while!!!
        
        $words = array();
        $dname = $d ? $this->options['templateDir'] .'/'.$d  : $this->options['templateDir'];
        //echo "Open $dname<BR>";
        $dh = opendir( $dname);
        require_once 'HTML/Template/Flexy.php';
        $o = $this->options;
        $o['fatalError'] = PEAR_ERROR_RETURN;
        $o['locale'] = 'en';
        while (($name = readdir($dh)) !== false) {
            $fname = $d ? $d .'/'. $name : $name;
            
            if ($name{0} == '.') {
                continue;
            }
            
            if (is_dir($this->options['templateDir'] . '/'. $fname)) {
                $this->compileAll($fname);
                continue;
            }
                
                
            if (!preg_match('/\.html$/',$name)) {
                continue;
            }
            
            $oo = $o;// $oo['debug'] = 1; 
            $x = new HTML_Template_Flexy( $oo );
            $r = $x->compile($fname);
            
            //printf(" %0.3fs : $fname<BR>", $time);
            if (is_a($r,'PEAR_Error')) {
                echo "compile failed on $fname<BR>";
                echo $r->toString();
                continue;
            }
            $this->words[$fname] = file_exists($x->getTextStringsFile) ?
                unserialize(file_get_contents($x->getTextStringsFile)) :
                array();
        }
        //echo '<PRE>';print_R($words);exit;
        
        ksort($this->words);
    }


    /**
    * delete all the compiled templates in  a specified language
    *
    * 
    * @param   string   language
    * @param   string   subdirectory of templateDir or empty
    * @return   none
    * @access   public
    */
    function clearTemplateCache($lang='en',$d = '') {
        
        $dname = $d ? $this->options['templateDir'] .'/'.$d  : $this->options['templateDir'];
       
        $dh = opendir($dname);
        while (($name = readdir($dh)) !== false) {
            $fname = $d ? $d .'/'. $name : $name;
            
            if ($name{0} == '.') {
                continue;
            }
            
            if (is_dir($this->options['templateDir'] . '/'. $fname)) {
                $this->clearTemplateCache($lang,$fname);
                continue;
            }
            if (!preg_match('/\.html$/',$name)) {
                continue;
            }
      
            $file = "{$this->options['compileDir']}/{$fname}.{$lang}.php";
            
            if (file_exists($file)) {
               // echo "DELETE $file?";
                unlink($file);
            }
        }
        clearstatcache();
    }
   /**
    * output the default template with the editing facilities.
    * 
    * @return   none
    * @access   public
    */
    function outputDefaultTemplate() {
        $o = array(
            'compileDir' => ini_get('session.save_path') . '/HTML_Template_Flexy_Translate',
            'templateDir' => dirname(__FILE__).'/templates'
        );
        $x = new HTML_Template_Flexy( $o );
        $x->compile('translator.html');
        $x->outputObject($this);
    }
        
      

}
