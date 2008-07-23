<?php

	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($argv[1]));
	foreach($files as $file) {
		echo("File: " . $file . ": ");
		chmod($file, 0666);
	}
?> 