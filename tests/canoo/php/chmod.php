<?php
/*
	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("@path/*"));
	echo("@path\n");
	foreach($files as $file) {
		echo("File: " . $file . "\n");
		chmod($file, 0666);
	}
*/
	exec('chmod -R a+rw @path/*');

?>