<?php
/**
 * xajaxResponse.inc.php :: xajax XML response class
 *
 * xajax version 0.2.5
 * copyright (c) 2005 by Jared White & J. Max Wilson
 * http://www.xajaxproject.org
 *
 * xajax is an open source PHP class library for easily creating powerful
 * PHP-driven, web-based Ajax Applications. Using xajax, you can asynchronously
 * call PHP functions and update the content of your your webpage without
 * reloading the page.
 *
 * xajax is released under the terms of the LGPL license
 * http://www.gnu.org/copyleft/lesser.html#SEC3
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package xajax
 * @copyright Copyright (c) 2005-2006  by Jared White & J. Max Wilson
 * @license http://www.gnu.org/copyleft/lesser.html#SEC3 LGPL License
 */

/*
   ----------------------------------------------------------------------------
   | Online documentation for this class is available on the xajax wiki at:   |
   | http://wiki.xajaxproject.org/Documentation:xajaxResponse.inc.php         |
   ----------------------------------------------------------------------------
*/

/**
 * The xajaxResponse class is used to create responses to be sent back to your
 * Web page.  A response contains one or more command messages for updating
 * your page.
 * Currently xajax supports 21 kinds of command messages, including some common
 * ones such as:
 * <ul>
 * <li>Assign - sets the specified attribute of an element in your page</li>
 * <li>Append - appends data to the end of the specified attribute of an
 * element in your page</li>
 * <li>Prepend - prepends data to the beginning of the specified attribute of
 * an element in your page</li>
 * <li>Replace - searches for and replaces data in the specified attribute of
 * an element in your page</li>
 * <li>Script - runs the supplied JavaScript code</li>
 * <li>Alert - shows an alert box with the supplied message text</li>
 * </ul>
 *
 * <i>Note:</i> elements are identified by their HTML id, so if you don't see
 * your browser HTML display changing from the request, make sure you're using
 * the right id names in your response.
 *
 * @package xajax
 */
class xajaxResponse
{
	/**#@+
	 * @access protected
	 */
	/**
	 * @var array internal command storage
	 */
	var $aCommands;
	/**
	 * @var string internal XML storage
	 */
	var $xml;
	/**
	 * @var string the encoding type to use
	 */
	var $sEncoding;
	/**
	 * @var boolean if special characters in the XML should be converted to
	 *              entities
	 */
	var $bOutputEntities;

	/**#@-*/

	/**
	 * The constructor's main job is to set the character encoding for the
	 * response.
	 *
	 * <i>Note:</i> to change the character encoding for all of the
	 * responses, set the XAJAX_DEFAULT_ENCODING constant before you
	 * instantiate xajax.
	 *
	 * @param string  contains the character encoding string to use
	 * @param boolean lets you set if you want special characters in the output
	 *                converted to HTML entities
	 *
	 */
	function __construct($sEncoding=XAJAX_DEFAULT_CHAR_ENCODING, $bOutputEntities=false)
	{
		$this->setCharEncoding($sEncoding);
		$this->bOutputEntities = $bOutputEntities;
		$this->aCommands = array();
	}

	/**
	 * Sets the character encoding for the response based on $sEncoding, which
	 * is a string containing the character encoding to use. You don't need to
	 * use this method normally, since the character encoding for the response
	 * gets set automatically based on the XAJAX_DEFAULT_CHAR_ENCODING
	 * constant.
	 *
	 * @param string
	 */
	function setCharEncoding($sEncoding)
	{
		$this->sEncoding = $sEncoding;
	}

	/**
	 * If true, tells the response object to convert special characters to HTML
	 * entities automatically (only works if the mb_string extension is
	 * available).
	 */
	function setOutputEntities($bOption)
	{
		$this->bOutputEntities = (boolean)$bOption;
		return $this;
	}

	/**
	 * Tells the response object to convert special characters to HTML entities
	 * automatically (only works if the mb_string extension is available).
	 */
	function outputEntitiesOn()
	{
		return ($this->setOutputEntities(true));
	}

	/**
	 * Tells the response object to output special characters intact. (default
	 * behavior)
	 */
	function outputEntitiesOff()
	{
		return ($this->setOutputEntities(false));
	}

	/**
	 * Adds a confirm commands command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addConfirmCommands(1, "Do you want to preview the new data?");</kbd>
	 *
	 * @param integer the number of commands to skip if the user presses
	 *                Cancel in the browsers's confirm dialog
	 * @param string  the message to show in the browser's confirm dialog
	 */
	function addConfirmCommands($iCmdNumber, $sMessage)
	{
		$this->addCommand(array('n'=>'cc','t'=>$iCmdNumber),$sMessage);
	    return $this;
	}

	function confirmCommands($iCmdNumber, $sMessage)
	{
		return $this->addConfirmCommands($iCmdNumber, $sMessage);
	}

	/**
	 * Adds an assign command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addAssign("contentDiv", "innerHTML", "Some Text");</kbd>
	 *
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to modify ("innerHTML",
	 *               "value", etc.)
	 * @param string the data you want to set the attribute to
	 */
	function addAssign($sTarget,$sAttribute,$sData)
	{
		$this->addCommand(array('n'=>'as','t'=>$sTarget,'p'=>$sAttribute),$sData);
		return $this;
	}

	function assign($sTarget,$sAttribute,$sData)
	{
		return $this->addAssign($sTarget,$sAttribute,$sData);
	}

	/**
	 * Adds an append command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addAppend("contentDiv", "innerHTML", "Some New Text");</kbd>
	 *
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to modify ("innerHTML",
	 *               "value", etc.)
	 * @param string the data you want to append to the end of the attribute
	 */
	function addAppend($sTarget,$sAttribute,$sData)
	{
		$this->addCommand(array('n'=>'ap','t'=>$sTarget,'p'=>$sAttribute),$sData);
		return $this;
	}

	function append($sTarget,$sAttribute,$sData)
	{
		return $this->addAppend($sTarget,$sAttribute,$sData);
	}

	/**
	 * Adds an prepend command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addPrepend("contentDiv", "innerHTML", "Some Starting Text");</kbd>
	 *
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to modify ("innerHTML",
	 *               "value", etc.)
	 * @param string the data you want to prepend to the beginning of the
	 *               attribute
	 */
	function addPrepend($sTarget,$sAttribute,$sData)
	{
		$this->addCommand(array('n'=>'pp','t'=>$sTarget,'p'=>$sAttribute),$sData);
		return $this;
	}

	function prepend($sTarget,$sAttribute,$sData)
	{
		return $this->addPrepend($sTarget,$sAttribute,$sData);
	}

	/**
	 * Adds a replace command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addReplace("contentDiv", "innerHTML", "text", "<b>text</b>");</kbd>
	 *
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to modify ("innerHTML",
	 *               "value", etc.)
	 * @param string the string to search for
	 * @param string the string to replace the search string when found in the
	 *               attribute
	 */
	function addReplace($sTarget,$sAttribute,$sSearch,$sData)
	{
		$aData[] = array('k'=>'s','v'=>$sSearch);
		$aData[] = array('k'=>'r','v'=>$sData);
		$this->addCommand(array('n'=>'rp','t'=>$sTarget,'p'=>$sAttribute),$aData);
		return $this;
	}

	function replace($sTarget,$sAttribute,$sSearch,$sData)
	{
		return $this->addReplace($sTarget,$sAttribute,$sSearch,$sData);
	}

	/**
	 * Adds a clear command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addClear("contentDiv", "innerHTML");</kbd>
	 *
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to clear ("innerHTML",
	 *               "value", etc.)
	 */
	function addClear($sTarget,$sAttribute)
	{
		$this->assign($sTarget,$sAttribute,'');
		return $this;
	}

	function clear($sTarget,$sAttribute)
	{
		return $this->addClear($sTarget,$sAttribute);
	}

	/**
	 * Adds an alert command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addAlert("This is important information");</kbd>
	 *
	 * @param string the text to be displayed in the Javascript alert box
	 */
	function addAlert($sMsg)
	{
		$this->addCommand(array('n'=>'al'),$sMsg);
		return $this;
	}

	function alert($sMsg)
	{
		return $this->addAlert($sMsg);
	}

	/**
	 * Uses the addScript() method to add a Javascript redirect to another URL.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->redirect("http://www.xajaxproject.org");</kbd>
	 *
	 * @param string the URL to redirect the client browser to
	 */
	function addRedirect($sURL, $iDelay=0)
	{
		//we need to parse the query part so that the values are rawurlencode()'ed
		//can't just use parse_url() cos we could be dealing with a relative URL which
		//  parse_url() can't deal with.
		$queryStart = strpos($sURL, '?', strrpos($sURL, '/'));
		if ($queryStart !== FALSE)
		{
			$queryStart++;
			$queryEnd = strpos($sURL, '#', $queryStart);
			if ($queryEnd === FALSE)
				$queryEnd = strlen($sURL);
			$queryPart = substr($sURL, $queryStart, $queryEnd-$queryStart);
			parse_str($queryPart, $queryParts);
			$newQueryPart = "";
			if ($queryParts)
			{
				$first = true;
				foreach($queryParts as $key => $value)
				{
					if ($first)
						$first = false;
					else
						$newQueryPart .= ini_get('arg_separator.output');
					$newQueryPart .= rawurlencode($key).'='.rawurlencode($value);
				}
			} else if ($_SERVER['QUERY_STRING']) {
				//couldn't break up the query, but there's one there
				//possibly "http://url/page.html?query1234" type of query?
				//just encode it and hope it works
				$newQueryPart = rawurlencode($_SERVER['QUERY_STRING']);
			}
			$sURL = str_replace($queryPart, $newQueryPart, $sURL);
		}
		if ($iDelay)
			$this->addScript('window.setTimeout("window.location = \''.$sURL.'\';",'.($iDelay*1000).');');
		else
			$this->addScript('window.location = "'.$sURL.'";');
		return $this;
	}

	function redirect($sURL, $iDelay=0)
	{
		return $this->addRedirect($sURL, $iDelay);
	}

	/**
	 * Adds a Javascript command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addScript("var x = prompt('get some text');");</kbd>
	 *
	 * @param string contains Javascript code to be executed
	 */
	function addScript($sJS)
	{
		$this->addCommand(array('n'=>'js'),$sJS);
		return $this;
	}

	function script($sJS)
	{
		return $this->addScript($sJS);
	}

	/**
	 * Adds a Javascript function call command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addScriptCall("myJSFunction", "arg 1", "arg 2", 12345);</kbd>
	 *
	 * @param string $sFunc the name of a Javascript function
	 * @param mixed $args,... optional arguments to pass to the Javascript function
	 */
	function addScriptCall()
	{
		$aArgs = func_get_args();
	    $sFunc = array_shift($aArgs);
	    $aData = $this->_buildObj($aArgs);
	    $this->addCommand(array('n'=>'jc','t'=>$sFunc),$aData);
	    return $this;
	}

	function call()
	{
		$aArgs = func_get_args();
		return call_user_func_array(array(&$this, 'addScriptCall'), $aArgs);
	}

	/**
	 * Adds a remove element command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addRemove("Div2");</kbd>
	 *
	 * @param string contains the id of an HTML element to be removed
	 */
	function addRemove($sTarget)
	{
		$this->addCommand(array('n'=>'rm','t'=>$sTarget),'');
		return $this;
	}

	function remove($sTarget)
	{
		return $this->addRemove($sTarget);
	}

	/**
	 * Adds a create element command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addCreate("parentDiv", "h3", "myid");</kbd>
	 *
	 * @param string contains the id of an HTML element to to which the new
	 *               element will be appended.
	 * @param string the tag to be added
	 * @param string the id to be assigned to the new element
	 * @param string deprecated, use the addCreateInput() method instead
	 */
	function addCreate($sParent, $sTag, $sId, $sType="")
	{
		if ($sType)
		{
			trigger_error("The \$sType parameter of addCreate has been deprecated.  Use the addCreateInput() method instead.", E_USER_WARNING);
			return;
		}
		$this->addCommand(array('n'=>'ce','t'=>$sParent,'p'=>$sId),$sTag);
		return $this;
	}

	function create($sParent, $sTag, $sId, $sType="")
	{
		return $this->addCreate($sParent, $sTag, $sId, $sType);
	}

	/**
	 * Adds a insert element command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addInsert("childDiv", "h3", "myid");</kbd>
	 *
	 * @param string contains the id of the child before which the new element
	 *               will be inserted
	 * @param string the tag to be added
	 * @param string the id to be assigned to the new element
	 */
	function addInsert($sBefore, $sTag, $sId)
	{
		$this->addCommand(array('n'=>'ie','t'=>$sBefore,'p'=>$sId),$sTag);
		return $this;
	}

	function insert($sBefore, $sTag, $sId)
	{
		return $this->addInsert($sBefore, $sTag, $sId);
	}

	/**
	 * Adds a insert element command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addInsertAfter("childDiv", "h3", "myid");</kbd>
	 *
	 * @param string contains the id of the child after which the new element
	 *               will be inserted
	 * @param string the tag to be added
	 * @param string the id to be assigned to the new element
	 */
	function addInsertAfter($sAfter, $sTag, $sId)
	{
		$this->addCommand(array('n'=>'ia','t'=>$sAfter,'p'=>$sId),$sTag);
		return $this;
	}

	function insertAfter($sAfter, $sTag, $sId)
	{
		return $this->addInsertAfter($sAfter, $sTag, $sId);
	}

	/**
	 * Adds a create input command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addCreateInput("form1", "text", "username", "input1");</kbd>
	 *
	 * @param string contains the id of an HTML element to which the new input
	 *               will be appended
	 * @param string the type of input to be created (text, radio, checkbox,
	 *               etc.)
	 * @param string the name to be assigned to the new input and the variable
	 *               name when it is submitted
	 * @param string the id to be assigned to the new input
	 */
	function addCreateInput($sParent, $sType, $sName, $sId)
	{
		$this->addCommand(array('n'=>'ci','t'=>$sParent,'p'=>$sId,'c'=>$sType),$sName);
		return $this;
	}

	function createInput($sParent, $sType, $sName, $sId)
	{
		return $this->addCreateInput($sParent, $sType, $sName, $sId);
	}

	/**
	 * Adds an insert input command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addInsertInput("input5", "text", "username", "input1");</kbd>
	 *
	 * @param string contains the id of the child before which the new element
	 *               will be inserted
	 * @param string the type of input to be created (text, radio, checkbox,
	 *               etc.)
	 * @param string the name to be assigned to the new input and the variable
	 *               name when it is submitted
	 * @param string the id to be assigned to the new input
	 */
	function addInsertInput($sBefore, $sType, $sName, $sId)
	{
		$this->addCommand(array('n'=>'ii','t'=>$sBefore,'p'=>$sId,'c'=>$sType),$sName);
		return $this;
	}

	function insertInput($sBefore, $sType, $sName, $sId)
	{
		return $this->addInsertInput($sBefore, $sType, $sName, $sId);
	}

	/**
	 * Adds an insert input command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addInsertInputAfter("input7", "text", "email", "input2");</kbd>
	 *
	 * @param string contains the id of the child after which the new element
	 *               will be inserted
	 * @param string the type of input to be created (text, radio, checkbox,
	 *               etc.)
	 * @param string the name to be assigned to the new input and the variable
	 *               name when it is submitted
	 * @param string the id to be assigned to the new input
	 */
	function addInsertInputAfter($sAfter, $sType, $sName, $sId)
	{
		$this->addCommand(array('n'=>'iia','t'=>$sAfter,'p'=>$sId,'c'=>$sType),$sName);
	    return $this;
	}

	function insertInputAfter($sAfter, $sType, $sName, $sId)
	{
		return $this->addInsertInputAfter($sAfter, $sType, $sName, $sId);
	}

	/**
	 * Adds an event command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addEvent("contentDiv", "onclick", "alert(\'Hello World\');");</kbd>
	 *
	 * @param string contains the id of an HTML element
	 * @param string the event you wish to set ("onclick", "onmouseover", etc.)
	 * @param string the Javascript string you want the event to invoke
	 */
	function addEvent($sTarget,$sEvent,$sScript)
	{
		$this->addCommand(array('n'=>'ev','t'=>$sTarget,'p'=>$sEvent),$sScript);
		return $this;
	}

	/**
	 * Adds a handler command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addHandler("contentDiv", "onclick", "content_click");</kbd>
	 *
	 * @param string contains the id of an HTML element
	 * @param string the event you wish to set ("onclick", "onmouseover", etc.)
	 * @param string the name of a Javascript function that will handle the
	 *               event. Multiple handlers can be added for the same event
	 */
	function addHandler($sTarget,$sEvent,$sHandler)
	{
		$this->addCommand(array('n'=>'ah','t'=>$sTarget,'p'=>$sEvent),$sHandler);
		return $this;
	}

	/**
	 * Adds a remove handler command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addRemoveHandler("contentDiv", "onclick", "content_click");</kbd>
	 *
	 * @param string contains the id of an HTML element
	 * @param string the event you wish to remove ("onclick", "onmouseover",
	 *               etc.)
	 * @param string the name of a Javascript handler function that you want to
	 *               remove
	 */
	function addRemoveHandler($sTarget,$sEvent,$sHandler)
	{
		$this->addCommand(array('n'=>'rh','t'=>$sTarget,'p'=>$sEvent),$sHandler);
		return $this;
	}

	function removeHandler($sTarget,$sEvent,$sHandler)
	{
		return $this->addRemoveHandler($sTarget,$sEvent,$sHandler);
	}

	/**
	 * Adds an include script command message to the XML response.
	 *
	 * <i>Usage:</i> <kbd>$objResponse->addIncludeScript("functions.js");</kbd>
	 *
	 * @param string URL of the Javascript file to include
	 */
	function addIncludeScript($sFileName)
	{
		$this->addCommand(array('n'=>'in'),$sFileName);
		return $this;
	}

	function includeScript($sFilename)
	{
		return $this->addIncludeScript($sFileName);
	}

	/**
	 * Returns the XML to be returned from your function to the xajax processor
	 * on your page. Since xajax 0.2, you can also return an xajaxResponse
	 * object from your function directly, and xajax will automatically request
	 * the XML using this method call.
	 *
	 * <i>Usage:</i> <kbd>return $objResponse->getXML();</kbd>
	 *
	 * @return string response XML data
	 */
	function getOutput()
	{
		$xml = "";
		if (is_array($this->aCommands))
		{
			foreach($this->aCommands as $aCommand)
			{
				$sData = $aCommand['data'];
				unset($aCommand['data']);
				$xml .= $this->_getXMLForCommand($aCommand, $sData);
			}
		}

		$charSet = '';
		$encoding = '';

		if (trim($this->sEncoding)) {
			$charSet = '; charset="'.$this->sEncoding.'"';
			$encoding = ' encoding="'.$this->sEncoding.'"';
		}

		@header('content-type: text/xml'.$charSet);
		return '<?xml version="1.0"'.$encoding.' ?'.'><xjx>'.$xml.'</xjx>';
	}

	function getXML()
	{
		return $this;
	}

	/**
	 * Adds the commands of the provided response XML output to this response
	 * object
	 *
	 * <i>Usage:</i>
	 * <code>$r1 = $objResponse1->getXML();
	 * $objResponse2->loadXML($r1);
	 * return $objResponse2->getXML();</code>
	 *
	 * @param string the response XML (returned from a getXML() method) to add
	 *               to the end of this response object
	 */
	function loadXML($mCommands)
	{
		if (is_a($mCommands, 'xajaxResponse')) {
			$this->aCommands = array_merge($this->aCommands, $mCommands->aCommands);
		}
		else if (is_array($mCommands)) {
			$this->aCommands = array_merge($this->aCommands, $mCommands);
		}
		else if (is_string($mCommands) && strpos($mXML, '<xjx>')!==false) {
			trigger_error("Using xajaxResponse->loadXML doesn't work with raw XML any more", E_USER_ERROR);
		}
		else {
			if (!empty($mCommands))
				trigger_error("The xajax response output could not load other commands as data was not a valid array", E_USER_ERROR);
		}
	}

	function loadCommands($mCommands)
	{
		return $this->loadXML($mCommands);
	}

	/**
	 * Generates XML from command data
	 *
	 * @access private
	 * @param array associative array of attributes
	 * @param string data
	 * @return string XML command
	 */
	function _cmdXML($aAttributes, $sData)
	{
		if ($this->bOutputEntities) {
			if (function_exists('mb_convert_encoding')) {
				$sData = call_user_func_array('mb_convert_encoding', array(&$sData, 'HTML-ENTITIES', $this->sEncoding));
			}
			else {
				trigger_error("The xajax XML response output could not be converted to HTML entities because the mb_convert_encoding function is not available", E_USER_NOTICE);
			}
		}
		$xml = "<cmd";
		foreach($aAttributes as $sAttribute => $sValue)
			$xml .= " $sAttribute=\"$sValue\"";
		if ($sData !== null && !stristr($sData,'<![CDATA['))
			$xml .= "><![CDATA[$sData]]></cmd>";
		else if ($sData !== null)
			$xml .= ">$sData</cmd>";
		else
			$xml .= "></cmd>";

		return $xml;
	}

	/**
	 * Generates XML from command data
	 *
	 * @access private
	 * @param array associative array of attributes
	 * @param mixed data
	 * @return string XML command
	 */
	function _getXMLForCommand($aAttributes, $mData)
	{
		$xml = '<cmd';
		foreach($aAttributes as $sAttribute => $sValue)
			if ($sAttribute)
				$xml .= " $sAttribute=\"$sValue\"";

		if (is_array($mData))
			$xml .= '>'.$this->_arrayToXML($mData).'</cmd>';
		else
			$xml .= '>'.$this->_escape($mData).'</cmd>';

		return $xml;
	}

	/**
	 * Converts an array of data into XML
	 *
	 * @access private
	 * @param mixed associative array of data or string of data
	 * @return string XML command
	 */
	function _arrayToXML($mArray) {
		if (!is_array($mArray))
			return $this->_escape($mArray);

		$xml = '<xjxobj>';
		foreach ($mArray as $aKey=>$aKeyValues) {
			if (is_array($aKeyValues)) {
				$xml .= '<e>';
				foreach($aKeyValues as $sKey => $sValue) {
					$xml .= '<'.htmlentities($sKey).'>';
					$xml .= $this->_arrayToXML($sValue);
					$xml .= '</'.htmlentities($sKey).'>';
				}
				$xml .= '</e>';
			} else {
				$xml .= '<e><k>';
				$xml .= $this->_escape($aKey);
				$xml .= '</k><v>';
				$xml .= $this->_escape($aKeyValues);
				$xml .= '</v></e>';
			}
		}
		$xml .= '</xjxobj>';

		return $xml;
	}

	/**
	 * Adds a commmand to the array of all commands
	 *
	 * @param array associative array of attributes
	 * @param mixed data
	 */
	function addCommand($aAttributes, $mData)
	{
		$aAttributes['data'] = $mData;
		$this->aCommands[] = $aAttributes;
	}

	/**
	 * Escapes the data.  Can be overridden to allow other transports to send
	 * data.
	 *
	 * @access private
	 * @param string data
	 * @return string escaped data
	 */
	function _escape($sData)
	{
		if (!is_numeric($sData) && !$sData)
			return '';

		$needCDATA = false;

		if ($this->bOutputEntities) {
			if (!function_exists('mb_convert_encoding'))
				trigger_error('The xajax response output could not be converted to HTML entities because the mb_convert_encoding function is not available', E_USER_NOTICE);

			$sData = call_user_func_array('mb_convert_encoding', array(&$sData, 'HTML-ENTITIES', $this->sEncoding));
		} else {
			if ((strpos($sData, '<![CDATA[') !== false)
			|| (strpos($sData, ']]>') !== false)
			|| (htmlentities($sData) != $sData))
				$needCDATA = true;

			$segments = explode('<![CDATA[', $sData);
			$sData = '';
			foreach ($segments as $key => $segment) {
				$fragments = explode(']]>', $segment);
				$segment = '';
				foreach ($fragments as $fragment) {
					if ($segment != '')
						$segment .= ']]]]><![CDATA[>';
					$segment .= $fragment;
				}
				if ($sData != '')
					$sData .= '<![]]><![CDATA[CDATA[';
				$sData .= $segment;
			}
		}

		if ($needCDATA)
			$sData = '<![CDATA['.$sData.']]>';

		return $sData;
	}

	/**
	 * Recursively serializes a data structure in an array so it can be sent to
	 * the client. It could be thought of as the opposite of
	 * {@link xajax::_parseObjXml()}.
	 *
	 * @access private
	 * @param mixed data structure to serialize
	 * @return array data ready for insertion into command list array
	 */
	function _buildObj($mData) {
	    if (gettype($mData) == 'object')
			$mData = get_object_vars($mData);

	    if (is_array($mData)) {
	    	$aData = array();
	        foreach ($mData as $key => $value)
				$aData[] = array(
					'k'=>$this->_buildObj($key),
					'v'=>$this->_buildObj($value)
				);
	        return $aData;
	    } else
			return $mData;
	}

}// end class xajaxResponse
