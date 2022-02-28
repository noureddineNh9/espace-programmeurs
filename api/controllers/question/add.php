<?php

session_start();
include_once '../../database/config.php';


$id_programmeur = mysqli_real_escape_string($conn, $_POST['id_programmeur']);
$titre = mysqli_real_escape_string($conn, $_POST['titre']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
if (!empty($id_programmeur) && !empty($titre) && !empty($description) ){
   $query = "INSERT INTO Question(titre, description, id_programmeur) 
             values('$titre', '$description', $id_programmeur) ";
   $res = mysqli_query($conn ,$query);
   if($res){
      echo 'success';
   }else{
      echo "Something went wrong. Please try again!";
   }
}else {
   echo 'form not valide';
}

?>