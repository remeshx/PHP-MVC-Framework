<?php

//directory provider
function load($directory)
{
	foreach (glob($directory."*.php") as $filename)
	{
	    require_once $filename;
	}
}