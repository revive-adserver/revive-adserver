<html>
<head>
<title>XML-RPC invocation test</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<h1>RPC-XML Invocation test</h1>
<?php
    require('lib-xmlrpc-class.inc.php');
    $xmlrpcbanner = new phpAds_XmlRpc('your.server.com', '');
    $bannerid = $xmlrpcbanner->view('', 0, '', '', '0');
?>
</body>
</html>
