<?php

ob_start();

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

$_GET['bannerid'] = 2;

define('MAX_PATH', './../..');
require_once MAX_PATH . '/www/delivery/apu.php';
?>
</script>
</body>
</html>
<?php

ob_end_flush();

?>