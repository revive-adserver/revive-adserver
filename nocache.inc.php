<?php
# suggestion of Bjoern Hoehrmann in d.c.l.php #
$now = gmdate("D, d M Y H:i:s") . " GMT";
header("Date: $now");
header("Expires: $now");
header("Last-Modified: $now");
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
?>