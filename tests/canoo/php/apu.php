<?php
    $webPath = substr($_SERVER['REQUEST_URI'], 0, 
        strlen($_SERVER['REQUEST_URI']) - strlen('apu.php')) . 'delivery/apu.php';
?>
<html>
<head>
<title>Example Web Page</title>
</head>
<body>
<script type='text/javascript'>
<?php
echo file_get_contents('http://'.$_SERVER['HTTP_HOST'].$webPath.'?n=&bannerid=2');
?>
</script>
</body>
</html>