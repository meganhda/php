<?php	
session_start();	//reprend une session existante
		

header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Headers: https://mybibli.netlify.app");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET");

		if(isset($_SESSION['User'])){	
		session_destroy();		//la fonction qui détruit la session
		http_response_code(200);	//code envoyer parce que la deconnexion est reussie
		}
		else {
		http_response_code(403);	//code envoyer quand la dexonnexion n'est pas reussie
		}
?>