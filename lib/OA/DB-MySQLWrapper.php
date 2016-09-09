<?php

if (!function_exists('mysql_connect'))
{
	require_once MAX_PATH . '/lib/mysql/MySQL.php';
	require_once MAX_PATH . '/lib/mysql/MySQL_Definitions.php';
	require_once MAX_PATH . '/lib/mysql/MySQL_Functions.php';
}

if (!function_exists('is_resource_custom'))
{
	function is_resource_custom($resource)
	{
		return is_resource($resource);
	}
}

