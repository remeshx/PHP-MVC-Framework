<?php

function response($data, $status = null, $responseCode = null)
{
	header('Content-Type: application/json');
	(function_exists('http_response_code') && $responseCode !== null) ? http_response_code($responseCode) : '';
	$data = $status === null ? $data : ['status' => $status, 'data' => $data] ;
	echo json_encode($data);
}

function apiData($data, $callback = null)
{
	$response = new \Core\API\Response();
	return $response->apiResponse($data, $callback);
}