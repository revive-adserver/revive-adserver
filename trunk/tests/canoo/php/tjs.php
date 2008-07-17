<?php

$fileName = 'tjs.php';

$webPath = substr($_SERVER['REQUEST_URI'], 0, strlen($_SERVER['REQUEST_URI']) - strlen('delivery_test/'.$fileName))."delivery/$fileName";

$debug = '';
//$debug = '&start_debug=1&debug_port=10000&debug_host=127.0.0.1&debug_stop=1';

?>
<html>
<head>
<title>Example Web Page (tjs.php)</title>
</head>
<body>

<script type='text/javascript'><!--//<![CDATA[
    var boo = '123';
    var foo = 'test_string';
//]]>--></script>

<script type='text/javascript'><!--//<![CDATA[
    var OA_p=location.protocol=='https:'?'https:':'http:';
    var OA_r=Math.floor(Math.random()*999999);
    document.write ("<" + "script language='JavaScript' ");
    document.write ("type='text/javascript' src='"+OA_p);
    document.write ("<?php echo '//'.$_SERVER['HTTP_HOST'].$webPath; ?>");
    document.write ("?trackerid=1&amp;r="+OA_r+"'><" + "\/script>");
//]]>--></script>

</body>
</html>

