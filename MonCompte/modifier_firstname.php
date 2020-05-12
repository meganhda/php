<?php
session_start();	//reprend la session

header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Headers: https://mybibli.netlify.app");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: POST");


//la connexion à la base de données


try{
	$pdo = new PDO('mysql:host=localhost;dbname=mybibli', 'root', 'root');
	$retour["success"] = true;
	$retour["message"] = "Connexion à la base de données réussie";

} catch(Exception $e){
	$retour["success"] = false;
	$retour["message"] = "Connexion à la base de données impossible";
}		
			$email = $_SESSION['User'];				//la variable qui contient le mail qui se trouve dans la session

			//la requete pour mettre à jour le prenom de l'utilisateur en session

			$requete = $pdo->prepare('UPDATE user set firstname=:firstname WHERE email="'.$email.'" ');
			$requete->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);			


	if( $requete->execute() ){						//si la requete s'execute un code et un message sont envoyer
							$retour["success"] = true;
							$retour["message"] = "le prenom a ete MAJ.";								
							http_response_code(200);					
	} else {										//si la requete ne s'execute pas un code et un message sont envoyer
							$retour["success"] = false;
							$retour["message"] = "Erreur";
							http_response_code(403);
	}

	//l'envoi du code et message

	echo (json_encode($retour));	
?>

