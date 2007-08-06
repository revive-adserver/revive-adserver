<?php
// signup.php, signup.common.php, signup.server.php
// demonstrate a a simple implementation of a multipage signup form
// using xajax version 0.2
// http://xajaxproject.org

require_once ("signup.common.php");

function processForm($aFormValues)
{
	if (array_key_exists("username",$aFormValues))
	{
		return processAccountData($aFormValues);
	}
	else if (array_key_exists("firstName",$aFormValues))
	{
		return processPersonalData($aFormValues);
	}
}

function processAccountData($aFormValues)
{
	$objResponse = new xajaxResponse();
	
	$bError = false;
	
	if (trim($aFormValues['username']) == "")
	{
		$objResponse->addAlert("Please enter a username.");
		$bError = true;
	}
	if (trim($aFormValues['newPass1']) == "")
	{
		$objResponse->addAlert("You may not have a blank password.");
		$bError = true;
	}
	if ($aFormValues['newPass1'] != $aFormValues['newPass2'])
	{
		$objResponse->addAlert("Passwords do not match.  Try again.");
		$bError = true;
	}

	if (!$bError)
	{
		$_SESSION = array();
		$_SESSION['newaccount']['username'] = trim($aFormValues['username']);
		$_SESSION['newaccount']['password'] = trim($aFormValues['newPass1']);
		
		$sForm = "<form id=\"signupForm\" action=\"javascript:void(null);\" onsubmit=\"submitSignup();\">";
		$sForm .="<div>First Name:</div><div><input type=\"text\" name=\"firstName\" /></div>";
		$sForm .="<div>Last Name:</div><div><input type=\"text\" name=\"lastName\" /></div>";
		$sForm .="<div>Email:</div><div><input type=\"text\" name=\"email\" /></div>";
		$sForm .="<div class=\"submitDiv\"><input id=\"submitButton\" type=\"submit\" value=\"done\"/></div>";
		$sForm .="</form>";
		$objResponse->addAssign("formDiv","innerHTML",$sForm);
		$objResponse->addAssign("formWrapper","style.backgroundColor", "rgb(67,149,97)");
		$objResponse->addAssign("outputDiv","innerHTML","\$_SESSION:<pre>".var_export($_SESSION,true)."</pre>");
	}
	else
	{
		$objResponse->addAssign("submitButton","value","continue ->");
		$objResponse->addAssign("submitButton","disabled",false);
	}
	
	return $objResponse;
}

function processPersonalData($aFormValues)
{
	$objResponse = new xajaxResponse();
	
	$bError = false;
	if (trim($aFormValues['firstName']) == "")
	{
		$objResponse->addAlert("Please enter your first name.");
		$bError = true;
	}
	if (trim($aFormValues['lastName']) == "")
	{
		$objResponse->addAlert("Please enter your last name.");
		$bError = true;
	}
	if (!eregi("^[a-zA-Z0-9]+[_a-zA-Z0-9-]*(\.[_a-z0-9-]+)*@[a-z??????0-9]+(-[a-z??????0-9]+)*(\.[a-z??????0-9-]+)*(\.[a-z]{2,4})$", $aFormValues['email']))
	{
		$objResponse->addAlert("Please enter a valid email address.");
		$bError = true;
	}

	if (!$bError)
	{
		$_SESSION['newaccount']['firstname'] = $aFormValues['firstName'];
		$_SESSION['newaccount']['lastname'] = $aFormValues['lastName'];
		$_SESSION['newaccount']['email'] = $aFormValues['email'];
		
		$objResponse->addAssign("formDiv","style.textAlign","center");
		$sForm = "Account created.<br />Thank you.";
		$objResponse->addAssign("formDiv","innerHTML",$sForm);
		$objResponse->addAssign("formWrapper","style.backgroundColor", "rgb(67,97,149)");
		$objResponse->addAssign("outputDiv","innerHTML","\$_SESSION:<pre>".var_export($_SESSION,true)."</pre>");
	}
	else
	{
		$objResponse->addAssign("submitButton","value","done");
		$objResponse->addAssign("submitButton","disabled",false);
	}
	
	return $objResponse;
}

$xajax->processRequests();
?>