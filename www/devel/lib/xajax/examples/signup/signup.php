<?php
// signup.php, signup.common.php, signup.server.php
// demonstrate a a simple implementation of a multipage signup form
// using xajax version 0.2
// http://xajaxproject.org

require_once('signup.common.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<?php $xajax->printJavascript('../../'); ?>
		<style type="text/css">
		#formWrapper{
			color: rgb(255,255,255);
			background-color: rgb(149,67,97);
			width: 200px;
		}
		#title{
			text-align: center;
			background-color: rgb(0,0,0);
		}
		#formDiv{
			padding: 25px;
		}
		.submitDiv{
			margin-top: 10px;
			text-align: center;
		}
		</style>
		<script type="text/javascript">
		function submitSignup()
		{
			xajax.$('submitButton').disabled=true;
			xajax.$('submitButton').value="please wait...";
			xajax_processForm(xajax.getFormValues("signupForm"));
			return false;
		}
		</script>
	</head>
	<body>
		<div id="formWrapper">
		
			<div id="title">Create a New Account</div>
			
			<div id="formDiv">
				<form id="signupForm" action="javascript:void(null);" onsubmit="submitSignup();">
					<div>Username:</div><div><input type="text" name="username" /></div>
					<div>Password:</div><div><input type="password" name="newPass1" /></div>
					<div>Confirm Password:</div><div><input type="password" name="newPass2" /></div>
					<div class="submitDiv"><input id="submitButton" type="submit" value="continue ->"/></div>
				</form>
			</div>
			
		</div>
		
		<div id="outputDiv">
		</div>
	</body>
</html>