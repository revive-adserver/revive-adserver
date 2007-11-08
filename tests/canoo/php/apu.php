<?php
    $webPath = substr($_SERVER['REQUEST_URI'], 0, 
        strlen($_SERVER['REQUEST_URI']) - strlen('delivery_test/apu.php')) . 'delivery/apu.php';
?>
<html>
<head>
<title>Example Web Page</title>
</head>
<body>
<script type='text/javascript'>
<?php
$protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
echo file_get_contents($protocol.$_SERVER['HTTP_HOST'].$webPath.'?n=123&what=bannerid:2');
?>
</script>
</body>
</html>