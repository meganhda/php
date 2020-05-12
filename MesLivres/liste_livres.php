<?php
			//affichage des livres


header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, HEAD, POST");

session_start();	//reprend la session
$email = $_SESSION['User'];	//la variables qui contient le mail en session
	
			//affichage des livres


	//reprend une session existante
//la connexion à la base de données

try{
	$pdo = new PDO('mysql:host=localhost;dbname=mybibli', 'root', 'root');
	$retour["success"] = true;
	$retour["message"] = "Connexion à la base de données réussie";

} catch(Exception $e){
	$retour["success"] = false;
	$retour["message"] = "Connexion à la base de données impossible";
}
$retour['email']=$email;
$achat = 0;

//la requete pour récuperer les livres de l'utilisateur en cours de session

$requete = $pdo->prepare('SELECT * FROM ajout_livre where user=? and achat=? ORDER BY title');

//l'execution de la requete

$requete->execute(array($email, $achat));
$resultats = $requete->fetchAll();

//l'envoi des résultats au front

$retour["success"] = true;
$retour["message"] = "Voici les livres";
$retour["results"]["nb"] = count($resultats);
$retour["results"]["livres"] = $resultats;


echo json_encode($retour);



 

 