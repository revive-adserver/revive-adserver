<?php
// thewall.php, thewall.common.php, thewall.server.php
// demonstrate a demonstrates a xajax implementation of a graffiti wall
// using xajax version 0.2
// http://xajaxproject.org

require_once("thewall.common.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>The Graffiti Wall</title>
		<?php $xajax->printJavascript('../../'); ?>
		<script>
		function update()
		{
			xajax_updateWall();
			setTimeout("update()", 30000);
		}
		</script>
		<style type="text/css">
		div.label{
			clear: both;
			float:left;
			width:60px;
			text-align:right;
			font-size: small;
		}
		#handle{
			font-size: x-small;
			width: 100px;
		}
		#words{
			font-size: x-small;
			width: 400px;
		}
		#post{
			font-size: small;
			margin-left: 390px;
		}
		#theWall{
			background-image: url('brick.jpg');
			height: 300px;
			padding: 50px;
			border: 3px outset black;
			overflow: auto;
		}
		.notice{
			font-size: small;
		}
		</style>
	</head>
	<body>
		<form id="scribbleForm" onsubmit="return false;">
			<div class="label">Handle:</div><input id="handle" name="handle" type="text" /><div></div>
			<div class="label">Graffiti:</div><input id="words" name="words"type="text" maxlength="75"/><div></div>
			<input id="post" type="submit" value="scribble" onclick="xajax_scribble(xajax.getFormValues('scribbleForm'));" />
		</form>
		<div class="notice">To see xajax's UTF-8 support, try posting words in other languages.  You can copy and paste from <a href="http://www.unicode.org/iuc/iuc10/x-utf8.html" target="_new">here</a></div>
		<div id="theWall">
		</div>
		<div style="text-align:center;">
		powered by <a href="http://www.xajaxproject.org">xajax</a>
		</div>
		<script>
			update();
		</script>
	</body>
</html>