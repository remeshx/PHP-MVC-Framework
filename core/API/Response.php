<?php

namespace Core\API;


class Response
{

	public function apiResponse($data, $callback = null)
	{
		if($callback === null) 
		{		
			return $data;
		}else{
			$responseArray = [];
			foreach ($data as $value) 
			{
				array_push($responseArray, $callback($value));
			}
			return $responseArray;
		}
	}

}