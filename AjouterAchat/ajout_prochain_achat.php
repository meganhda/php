<?php
    header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
    header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
    header("Access-Control-Allow-Headers: https://mybibli.netlify.app");
    header("Content-Type: application/json; charset=UTF-8");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: POST");    
	$data = json_decode(file_get_contents("php://input"));
    session_start();				//on reprend une session existante
    $link = mysqli_connect("localhost", "root", "root", "mybibli") or die("Erreur");	//la connexion à la base de données
    mysqli_select_db($link,"mybibli") or die("La base de données est introuvable");


    $title=$_POST['title'];
    $author=$_POST['author'];
    $user = $_SESSION['User'];
    $valeur = "1";
    $achat1= "0";
    if(!empty($title) AND !empty($author)) //vérifie que les champs sont remplis
    {

    	// la requete qui verifie que le titre et l'auteur existe dans la table
        $sql = "SELECT COUNT(*) AS nbr FROM ajout_livre WHERE title = '".$_POST['title']."' AND author = '".$_POST['author']."' AND (achat='".$achat1."') AND (user = '".$user."') ";
        $res = mysqli_query($link,$sql);
        $alors = mysqli_fetch_assoc($res);
       
        if(isset($_POST['title']))
        {


            if(!($alors['nbr'] == 0))	//si le resultat est differend de 0, ca veut dire que le livre existe déja dans la bibliothèque, on renvoi un code d'erreur
            {
        		echo "Echec: ce livre existe déjà dans votre bibliothèque!";    	
                http_response_code(403);		
            }
            else
            {
            	//else on verifie que le livre n'est pas déja dans la liste d'achat
        	$requete = "SELECT COUNT(*) AS nbrs FROM ajout_livre WHERE title = '".$_POST['title']."' AND author = '".$_POST['author']."' AND (achat='".$valeur."')";
    	    $results = mysqli_query($link,$requete);
 	        $donc = mysqli_fetch_assoc($results);

 	        if(!($donc['nbrs'] == 0))		//on renvoie un code d'erreur si le livre est déja dans la liste d'achat
 	        {
        		echo "Echec: ce livre existe déjà dans votre liste d'achat!";    	
                http_response_code(403);
 	        }	
 	        else {							// else on ajoute le livre dans la table 
                mysqli_query($link,'INSERT INTO ajout_livre (title,author,user,achat) VALUES ("'.$title.'","'.$author.'","'.$user.'","'.$valeur.'" )') or die ('Erreur:'.mysqli_error($link));

            	echo "Votre livre a été ajouté à votre liste d'achats";        
            }
        	}        
    	}
    	
    } else {
       	echo "Erreur, un ou plusieurs champs est vide."; 			// si les champs sont pas remplis, un code est renvoyer
        http_response_code(403);	
    } 
?>