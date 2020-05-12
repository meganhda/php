<?php
	session_start(); //nous permet de débuter une session
	header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
	header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
	header("Access-Control-Allow-Headers: https://mybibli.netlify.app");
	header("Content-Type: application/json; charset=UTF-8");
	header('Access-Control-Allow-Credentials: true');
	header("Access-Control-Allow-Methods: POST");
	$con=mysqli_connect('localhost', 'root', 'root', 'mybibli');//la fonction qui permet de se connecter à la bdd	
	if(!$con){													//si une erreur est survenue pendant la connexion à la bdd
		die('erreur de connexion avec la base de donnée'.mysql_error());	//die = exit(), avec un message d'erreur 
	}
		$email = $_POST['email'];
		$password = $_POST['password'];

		//$email = strip_tags(mysqli_real_escape_string($con, trim($email)));
		//$password = strip_tags(mysqli_real_escape_string($con, trim($password)));		
		//requete pour chercher si le mail reçu existe dans la table
		$query = "SELECT * FROM user where email='".$email."'";	
		$hi = mysqli_query($con, $query);
		if(mysqli_num_rows($hi) > 0){

			//si le mail existe, dans ce cas on verifie que le mot de passe est correct	

			$row = mysqli_fetch_array($hi);
			$password_hash = $row['password'];
			if(password_verify($password, $password_hash)){
			$_SESSION['User']=$_POST['email'];	// on recupere le mail dans une variable $_SESSION['User']
			http_response_code(200);			//un code est envoyer parce que la connexion est reussie
			}
			else {
				echo"Mot de passe non valide";
				http_response_code(403);			//le mot de passe est incorrect, le code 403 est envoyé	
			}
		}
		else{
			echo"Aucun compte utilisateur rattaché à cette adresse email";
			http_response_code(403);			// le mail n'existe pas, le code 403 est envoyé.
		}
?>