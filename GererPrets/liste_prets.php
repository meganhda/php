<?php 

			//affichage des prets en cours

session_start();		//reprend une session existante
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
$email = $_SESSION['User'];
$achat = 0;
$pret = "Non Disponible";

//la requete qui permet de recuperer tout les livres avec le statut "Non Disponible" d'un utilisateur

$requete = $pdo->prepare('SELECT * FROM ajout_livre where user=? and achat=? and status=?');

//l'execution de la requete

$requete->execute(array($email, $achat, $pret));
$resultats = $requete->fetchAll();

//Envoi des resultats

$retour["success"] = true;
$retour["message"] = "Voici les livres";
$retour["results"]["nb"] = count($resultats);
$retour["results"]["livres"] = $resultats;


echo json_encode($retour);



 