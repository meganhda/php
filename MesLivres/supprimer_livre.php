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
		
		//requete pour supprimer un livre

		$requete = $pdo->prepare('DELETE FROM ajout_livre where id=:id LIMIT 1');

		$requete->bindValue(':id', $_POST['id'], PDO::PARAM_INT);	
		if($requete->execute()){	//si la requete est executé un code et un message sont envoyées au front
			$retour["success"] = true;
			$retour["message"] = "le livre a ete supprime";

			http_response_code(200);					

		}
		else {
			$retour["success"] = false;	//si la requete n'est pas executé un code et un message sont envoyées au front
			$retour["message"] = "echec de la suppression du livre";			
			http_response_code(403);					

		}
		echo json_encode($retour);
?>