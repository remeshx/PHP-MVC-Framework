<?php

function auth($authType = AUTH_USER)
{
	return new \Core\Auth\Authentication($authType);
}

