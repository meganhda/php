<?php
session_start();	//reprend la session
$email = $_SESSION['User'];	//reprend le mail qui est initialisé dans la variable superglobale $_SESSION['User'] l'or de la connexion
header("Access-Control-Allow-Origin: hhttps://mybibli.netlify.app");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, HEAD, POST");


//connexion à la base de données

try{
	$pdo = new PDO('mysql:host=localhost;dbname=mybibli', 'root', 'root');
	$retour["success"] = true;
	$retour["message"] = "Connexion à la base de données réussie";

} catch(Exception $e){
	$retour["success"] = false;
	$retour["message"] = "Connexion à la base de données impossible";
}


//requete pour recuperer les données de l'utilisateur en cours de session

$requete = $pdo->prepare('SELECT email, firstname, lastname FROM user where email=?');

//l'execution de la requete

$requete->execute(array($email));
$resultats = $requete->fetchAll();


//l'envoi des données

$retour["success"] = true;
$retour["message"] = "Voici les informations du profile";
$retour["results"]["profile"] = $resultats;


echo(json_encode($retour));



 