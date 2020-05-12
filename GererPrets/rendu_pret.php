<?php
session_start();	//reprend la session
header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Headers: https://mybibli.netlify.app");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: POST");

//la connexion à la base de données

$conn = new mysqli('localhost', 'root', 'root', 'mybibli');  

try{
	$pdo = new PDO('mysql:host=localhost;dbname=mybibli', 'root', 'root');
	$retour["success"] = true;
	$retour["message"] = "Connexion à la base de données réussie";

} catch(Exception $e){
	$retour["success"] = false;
	$retour["message"] = "Connexion à la base de données impossible";
}
		
		$user = $_SESSION['User'];	//variable qui contient le mail de l'utilisateur en cours de session

		//la requete pour mettre à jour l'attribut "returnDate" ainsi que le status du livre  

		$requete = $pdo->prepare('UPDATE ajout_livre set returnDate=:returnDate ,status=:status where id=:id LIMIT 1');

		//l'association des valeurs aux parametres de la requete

		$requete->bindValue(':id', $_POST['id'], PDO::PARAM_INT);	
		$requete->bindValue(':returnDate', $_POST['returnDate'], PDO::PARAM_STR);	
		$requete->bindValue(':status', "Disponible", PDO::PARAM_STR);			
		if($requete->execute()){	//si la requete s'execute on envoi un code et un message 
			$retour["success"] = true;
			$retour["message"] = "le livre a ete rendu.";

			//la requete pour selectioner le titre l'auteur, l'emprunteur et la date du pret du livre

			$livre = $pdo->prepare(' SELECT title, author,borrower, borrowDate from ajout_livre where id =? ');

			//l'execution de la requete

			$livre->execute(array($_POST['id']));
			$resultats =$livre->fetchAll();
			
			foreach ($resultats as $resultat) {
					

					//l'insertion des données recuperer du livre dans la table history pour récuperer l'historique d'un pret à chaque fois

					$req  = $conn->prepare('INSERT INTO history (title, author, date1 ,date2, borrower, user) VALUES (?,?,?,?,?,?)');
					$req->bind_param("ssssss",  $resultat['title'], $resultat['author'], $resultat['borrowDate'] ,$_POST['returnDate'], $resultat['borrower'], $user);

					//l'execution de la requete

					$req->execute();
					//code 200 pour dire que tout est reussi
					http_response_code(200);												
			}

		}
		else {			//si notre premiere requete n'a pas été executé un code d'erreur est envoyer au front
			$retour["success"] = false;
			$retour["message"] = "echec.";			
			http_response_code(403);					

		}
		//l'envoi des codes ainsi des messages 
		echo json_encode($retour);
?>