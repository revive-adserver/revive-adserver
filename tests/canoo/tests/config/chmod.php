<?php
	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($argv[2]));
	foreach($files as $file) {
		chmod($file, 0666);
	} 
?> 