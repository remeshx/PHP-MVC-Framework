<?php

function dd($value, $die = true)
{
	var_dump($value);
	if($die)
		exit;
}


function ddd($value, $die = true)
{
	header("content-Type: Application/json");
	echo json_encode($value);
	if($die)
		exit;
}
