<?php

			//affichage de la liste des prochains achats


session_start();	//reprend une session existante
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
$achat = 1;

//la requete pour récuperer les livres de l'utilisateur en cours de session


$requete = $pdo->prepare('SELECT * FROM ajout_livre where user=? and achat=?');

//l'execution de la requete

$requete->execute(array($email, $achat));
$resultats = $requete->fetchAll();

//l'envoi des résultats au front


$retour["success"] = true;
$retour["message"] = "Voici les livres";
$retour["results"]["nb"] = count($resultats);
$retour["results"]["livres"] = $resultats;


echo json_encode($retour);



 