<?php

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

//la requete pour mettre à jour les données d'un livre

$requete = $pdo->prepare('UPDATE ajout_livre set title=:title, author=:author, year=:year, date=:date, edition=:edition, typeBook=:typeBook WHERE id=:id ');
			
			//Association des données reçus au parametres de la requete

			$requete->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
			$requete->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
			$requete->bindValue(':author', $_POST['author'], PDO::PARAM_STR);
			$requete->bindValue(':year', $_POST['year'], PDO::PARAM_INT);
			$requete->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
			$requete->bindValue(':edition', $_POST['edition'], PDO::PARAM_STR);
			$requete->bindValue(':typeBook', $_POST['typeBook'], PDO::PARAM_STR);
	
	if( $requete->execute() ){					//si la requete s'execute un code et un message sont envoyer au front
							$retour["success"] = true;
							$retour["message"] = "le livre a ete MAJ.";								
							http_response_code(200);					
	} else {									//si la requete ne s'execute pas un code et un message sont envoyer au front
							$retour["success"] = false;
							$retour["message"] = "Erreur";
							http_response_code(403);
	}

	//l'envoi du code et message

	echo (json_encode($retour));	
?>

