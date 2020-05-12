<?php
session_start();	//reprend la session en cours
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

	
		$user = $_SESSION['User'];	//recuperer le mail de l'utilisateur en session dans la variable $user
		$achat = "0";
		
		//preparation de la requete pour completer les informations d'un livre. on change aussi le statut de l'attribut "achat" pour que le livre s'affiche dans la bibliothèque de l'utilisateur

		$requete = $pdo->prepare('UPDATE ajout_livre set year=:year, date=:date, edition=:edition, typeBook=:typeBook, status=:status, user=:user, achat=:achat where id=:id LIMIT 1');		

		//l'association des valeurs aux parametres de la requete

		$requete->bindValue(':id', $_POST['id'], PDO::PARAM_INT);	
		$requete->bindValue(':year', $_POST['year'], PDO::PARAM_INT);
		$requete->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
		$requete->bindValue(':edition', $_POST['edition'], PDO::PARAM_STR);
		$requete->bindValue(':typeBook', $_POST['typeBook'], PDO::PARAM_STR);
		$requete->bindValue(':status', "Disponible", PDO::PARAM_STR);
		$requete->bindValue(':user', $user, PDO::PARAM_STR);
		$requete->bindValue(':achat', $achat, PDO::PARAM_STR);
		if($requete->execute()){		//si la requete s'execute on envoi un code et un message au front

		$retour["success"] = true;
		$retour["message"] = "le livre a ete ajoute.";								
		http_response_code(200);
		}
		else {							//si la requete ne s'execute pas, un code d'erreur et un message sont envoyées au front
		$retour["success"] = false;
		$retour["message"] = "le livre n'a pas ete ajoute.";								
		http_response_code(403);
		}

		//l'envoi des données
		
		echo json_encode($retour);
?>						
	
