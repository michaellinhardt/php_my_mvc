<?php
if (preg_match('/localhost/si', $_SERVER['SERVER_NAME']))
{
	$aDbConfig = array(
	"host" => "localhost",
	"name" => "resastock",
	"user" => "root",
	"pass" => "root",
	);
}
else
{
	$aDbConfig = array(
	"host" => "localhost",
	"name" => "resastock",
	"user" => "root",
	"pass" => "root",
	);
}
