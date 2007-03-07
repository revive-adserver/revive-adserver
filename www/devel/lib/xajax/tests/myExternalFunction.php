<?php
function myExternalFunction()
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert('External function successfully included and executed');
	return $objResponse;
}

class myExternalClass
{
	function myMethod()	// static (can't hardwire that in because of PHP 4)
	{
		$objResponse = new xajaxResponse();
		$objResponse->addAlert('External class successfully included and method executed');
		return $objResponse;
	}
}
?>
<p> This is some content that should be ignored by an asynchronous request
 through xajax, but will show up if the file is otherwise included into the script. </p>