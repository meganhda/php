<?php

session_start();	//reprend la session existante
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

} 
//message d'erreur s'il y'a un probléme avec la connexion à la bse de données

catch(Exception $e){
	$retour["success"] = false;
	$retour["message"] = "Connexion à la base de données impossible";
}

$email = $_SESSION['User'];
$achat = "0";
$recherche = $_POST['typeBook'];

//requete qui permet de recuperer les informations voulus


$requete = $pdo->prepare('SELECT * FROM ajout_livre where (typeBook like "%'.$recherche.'%") and (user=?) and (achat=?)');

//l'execution de la requete


$requete->execute(array($email, $achat));
$resultats = $requete->fetchAll();


$retour["success"] = true;
$retour["message"] = "Voici les livres";
$retour["results"]["nb"] = count($resultats);
$retour["results"]["livres"] = $resultats;


echo json_encode($retour);


