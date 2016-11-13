<?php
if (preg_match('/localhost/si', $_SERVER['SERVER_NAME']))
{
	$aDbConfig = array(
	"host" => "localhost",
	"name" => "bocooliz",
	"user" => "root",
	"pass" => "",
	);
}
else
{
	$aDbConfig = array(
	"host" => "localhost",
	"name" => "bocooliz",
	"user" => "root",
	"pass" => "",
	);
}