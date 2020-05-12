<?php

			//affichage d'historique des prets des livres


session_start();	//reprend la session en cours
header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, HEAD, POST");

//la connexion à la base de données

try{
	$pdo = new PDO('mysql:host=localhost;dbname=mybibli', 'root', 'root');
	$retour["success"] = true;
	$retour["message"] = "Connexion à la base de données réussie";

} catch(Exception $e){
	$retour["success"] = false;
	$retour["message"] = "Connexion à la base de données impossible";
}

$user = $_SESSION['User'];	//variable qui contient le mail de l'utilisateur en cours de session

//la requete pour selectioner l'historique des livres de l'utilisateur

$req = $pdo->prepare('SELECT * FROM history where user=:user');

//l'association de la valeur reçu avec les parametres de la requete

$req->bindValue(':user', $user, PDO::PARAM_STR);	

//l'execution de la requete

$req->execute();

//recuperation des resultats dans la variable results
$results = $req->fetchAll();

//l'initialisation des variables qui vont contenir des messages afin de les envoyer au front-end

$retour["success"] = true;
$retour["message"] = "Voici l'hisorique";
$retour["results"]["nb"] = count($results);
$retour["results"]["livres"] = $results;

echo json_encode($retour);

?>
