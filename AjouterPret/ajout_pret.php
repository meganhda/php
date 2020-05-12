<?php
		session_start();	//on reprend une session existante
		header("Access-Control-Allow-Origin:https://mybibli.netlify.app");
		header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
		header("Access-Control-Allow-Headers:https://mybibli.netlify.app");
		header("Content-Type: application/json; charset=UTF-8");
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Methods: POST");
		//la connexion à la base de données

		$conx = new PDO('mysql:host=localhost;dbname=mybibli', 'root', 'root');
		$conn = new mysqli('localhost', 'root', 'root', 'mybibli');  
	    
	    $email = $_SESSION['User'];
	    $title=$_POST['title'];
	    $author=$_POST['author'];
	    $borrower=$_POST['borrower'];
        $borrowDate=$_POST['borrowDate'];
        $status="Disponible";

        //la requete pour verifier que le livre existe dans la table pour pouvoir modifier le statut

	    $sql ="SELECT * FROM ajout_livre WHERE (title='".$title."') and (author='".$author."') AND (user='".$email."')";
		$result = mysqli_query($conn, $sql);
 			
 		if (mysqli_num_rows($result)>0) 
 		{

 			//la requete pour verifier que le statut du livre est "Disponible"

 			$requete = "SELECT * FROM ajout_livre WHERE (title='".$title."') and (author='".$author."') AND (user='".$email."') and (status='".$status."')";
 			$requetes = mysqli_query($conn, $requete);

 			if(mysqli_num_rows($requetes)>0)
 			{
			http_response_code(200);	//le code 200 est envoyer, parce que tout est bon.				

			//requete pour changer le statut du livre en "Non Disponible"

			$req = $conx->prepare('UPDATE ajout_livre set borrower=:borrower, borrowDate=:borrowDate, status=:status WHERE title=:title and author=:author and user=:email');
			
			$req->bindValue(':email', $email, PDO::PARAM_STR);
			$req->bindValue(':title', $title, PDO::PARAM_STR);
			$req->bindValue(':author', $author, PDO::PARAM_STR);
			$req->bindValue(':borrowDate', $borrowDate, PDO::PARAM_STR);
			$req->bindValue(':status', "Non Disponible", PDO::PARAM_STR);			
			$req->bindValue(':borrower', $borrower, PDO::PARAM_STR);
			$req->execute();
			}
			else 	//si le statut du livre est déja "Non disponible" on envoi un message avec un code d'erreur.
			{
			http_response_code(403);
			echo "Erreur: ce livre est déja prêté!";	
			}	
		}
		
		else 
		{			//un message et un code d'erreur sont envoyer parce que les conditions sont pas valables pour un changement de statut. 
            echo"Erreur: ce livre n'existe pas dans votre bibliothèque";
			http_response_code(403);					
		}		
?>

