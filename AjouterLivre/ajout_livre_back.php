<?php
    header("Access-Control-Allow-Origin: https://mybibli.netlify.app");
    header("Access-Control-Allow-Headers:  https://mybibli.netlify.app");
    header("Content-Type: application/json; charset=UTF-8");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: POST");        
    $data = json_decode(file_get_contents("php://input"));
    $link = mysqli_connect("localhost", "root", "root", "mybibli") or die("Erreur");
    session_start();		//on reprend une session existante
    //mysqli_connect("localhost","root","")or die("Erreur");
    mysqli_select_db($link,"mybibli") or die("La base de données est introuvable");	//la connexion à la base de données
    $title=$_POST['title'];
    $author=$_POST['author'];
    $year=$_POST['year'];
    $date=$_POST['date'];
    $edition=$_POST['edition'];
    $typeBook=$_POST['typeBook'];
    $status="Disponible";
    $user = $_SESSION['User'];
    $valeur = "0";
    $achat1 = "0";


    if(!empty($title) AND !empty($author) AND !empty($year) AND !empty($date) AND !empty($edition) AND !empty($typeBook) AND !empty($status)) //vérifie que les champs sont remplis
    {
    	// la requete qui verifie que le titre et l'auteur existe dans la table

        $sql = "SELECT COUNT(*) AS nbr FROM ajout_livre WHERE title = '".$_POST['title']."' and author ='".$_POST['author']."' and (achat='".$achat1."') and (user='".$user."')";
        $res = mysqli_query($link,$sql);
        $alors = mysqli_fetch_assoc($res);
       
        if(isset($_POST['title']))
        {
            if(!($alors['nbr'] == 0))		//s'il le resultat de la requete est different de 0, un code d'erreur et envoyer avec un message.
            {
                echo "Ce livre existe déjà dans votre bibliothèque";
                http_response_code(403);
            }
            else
            {

            		//si le livre n'existe pas déja dans la table, on l'ajoute. 
                mysqli_query($link,'INSERT INTO ajout_livre (title,author,year,date,edition,typeBook,status,user,achat) VALUES ("'.$title.'","'.$author.'","'.$year.'","'.$date.'","'.$edition.'","'.$typeBook.'","'.$status.'","'.$user.'", "'.$valeur.'")') or die ('Erreur:'.mysqli_error($link));echo"Votre livre a été ajouté";
            }
        }
        
    }
    else {				//code d'erreur si au moins une des champs n'est pas remplis
    http_response_code(403);
    echo "Erreur, un ou plusieurs champs est vide.";    
    }
    ?>