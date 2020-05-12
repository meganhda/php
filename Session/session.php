<?php
session_start();	//reprend la session
header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Headers: https://mybibli.netlify.app");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: POST");
	

	if(isset($_SESSION['User']))
	{
		http_response_code(200);	
	} 
	else 
	{
		http_response_code(404);
	}
?>
