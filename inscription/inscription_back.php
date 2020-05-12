<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    $data = json_decode(file_get_contents("php://input"));
    session_start();	//Démarre une nouvelle session
    $link = mysqli_connect("localhost", "root", "root", "mybibli") or die("Erreur");	//la connexion à la base de données
    //mysqli_connect("localhost","root","")or die("Erreur");
    mysqli_select_db($link,"mybibli") or die("La base de données est introuvable");
    $_SESSION['firstname']=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);	//la fonction pour sécuriser le mot de passe
    if(!empty($_SESSION['firstname']) AND !empty($lastname) AND !empty($email) AND !empty($password))	//la verification que les champs sont remplis
    {

    	//la verification que l'email n'existe pas déja dans la table 
    	
    	$sql = "SELECT COUNT(*) AS nbr FROM user WHERE email = '".$_POST['email']."' ";
        $res = mysqli_query($link,$sql);
        $alors = mysqli_fetch_assoc($res);
       
        if(isset($_POST['email']))
        {
            if(!($alors['nbr'] == 0))
            {
            	//un message est envoyer pour prévenir l'utilisateur que l'adresse mail saisie est déja prise

                echo "L’adresse e-mail '".$_POST['email']."' est déjà prise.";		 
                http_response_code(403);
            }
            else
            {

            	//l'insertion des données reçus dans la table

        		mysqli_query($link,'INSERT INTO user (firstname,lastname,email,password) VALUES ("'.$_SESSION['firstname'].'","'.$lastname.'","'.$email.'","'.$password.'")') or die ('Erreur:'.mysqli_error($link));echo"Votre compte a été enregistré avec succès";
        	}
        }
    }
    else echo "Erreur, un ou plusieurs champs est vide.";    //message d'erreur
    ?>