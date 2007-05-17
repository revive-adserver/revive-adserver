<?php
// thewall.php, thewall.common.php, thewall.server.php
// demonstrate a demonstrates a xajax implementation of a graffiti wall
// using xajax version 0.2
// http://xajaxproject.org

if (!defined ('MAX_SCRIBBLES'))
{
	define ('MAX_SCRIBBLES', 5);
}

if (!defined ('DATA_FILE'))
{
	define ('DATA_FILE', "thewall.dta");
}

class graffiti
{
	var $html;
	var $isValid = false;
	
	function graffiti($sHandle, $sWords)
	{
		if (trim($sHandle) == "" || trim($sWords) == "")
		{
			return;
		}
		$this->html  = "\n<div style=\"font-weight: bold;text-align:".$this->getRandomAlignment();
		$this->html .= ";color:".$this->getRandomColor().";\">";
		$this->html .= "<span style=\"font-size:".$this->getRandomFontSize()."%;\">";
		$this->html .= strip_tags(stripslashes($sWords));
		$this->html .= "</span><br/><span style=\"font-size: small;\">";
		$this->html .= " ~ ".strip_tags(stripslashes($sHandle))." ".date("m/d/Y H:i:s")."</span></div>";
		
		$this->isValid = true;
	}
	
	function getRandomFontSize()
	{
		srand((double)microtime()*1000003);
		return rand(100,300);
	}
	
	function getRandomColor()
	{
		$sColor = "rgb(";
		srand((double)microtime()*1000003);
		$sColor .= rand(0,255).",";
		srand((double)microtime()*1000003);
		$sColor .= rand(0,255).",";
		$sColor .= rand(0,255).")";
		
		return $sColor;
	}
	
	function getRandomAlignment()
	{
		$sAlign = "";
		srand((double)microtime()*1000003);
		$textAlign = rand(0,2);
		switch($textAlign)
		{
			case 0: $sAlign = "left"; break;
			case 1: $sAlign = "right"; break;
			case 2: $sAlign = "center"; break;
			
		}
		return $sAlign;
	}
	
	function save()
	{
		if ($this->isValid)
		{
			$rFile = @fopen(DATA_FILE,"a+");
			if (!$rFile) {
				return "ERROR: the graffiti data file could not be written to the " . dirname(realpath(DATA_FILE)) . " folder.";
			}
			fwrite($rFile, $this->html);
			fclose($rFile);
			return null;
		}
		else
		{
			return "Please supply both a handle and some graffiti to scribble on the wall.";
		}
	}
}

function scribble($aFormValues)
{
	$sHandle = $aFormValues['handle'];
	$sWords = $aFormValues['words'];
	$objResponse = new xajaxResponse();
	
	$objGraffiti = new graffiti($sHandle,$sWords);
	$sErrMsg = $objGraffiti->save();
	if (!$sErrMsg)
	{
		$objResponse->addScript("xajax_updateWall();");
		$objResponse->addClear("words","value");
	}
	else
		$objResponse->addAlert($sErrMsg);
	
	return $objResponse;
}

function updateWall()
{
	$objResponse = new xajaxResponse();
	
	if (file_exists(DATA_FILE)) {
		$aFile = @file(DATA_FILE);
		if (!$aFile) {
			$objResponse->addAlert("ERROR: the graffiti data file could not be written to the " . dirname(realpath(DATA_FILE)) . " folder.");
			return $objResponse;
		}
		
		$sHtmlSave = implode("\n",array_slice($aFile, -MAX_SCRIBBLES));
		$sHtmlSave=str_replace("\n\n","\n",$sHtmlSave);
	}
	else {
		$sHtmlSave = "";
		$aFile = array();
	}
	$rFile = @fopen(DATA_FILE,"w+");
	if (!$rFile) {
		$objResponse->addAlert("ERROR: the graffiti data file could not be written to the " . dirname(realpath(DATA_FILE)) . " folder.");
		return $objResponse;
	}
	fwrite($rFile, $sHtmlSave);
	fclose($rFile);
	
	$sHtml = implode("\n",array_reverse(array_slice($aFile, -MAX_SCRIBBLES)));
	
	$objResponse->addAssign("theWall","innerHTML",$sHtml);

	return $objResponse;
}

require("thewall.common.php");
$xajax->processRequests();
?>