<?php

session_start();
include_once '../../database/config.php';


$id_question = mysqli_real_escape_string($conn, $_POST['id_question']);
$id_programmeur = mysqli_real_escape_string($conn, $_POST['id_programmeur']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
if (!empty($id_question) && !empty($description) && !empty($id_programmeur) ){
   $query = "INSERT INTO Reponse(description, id_question, id_programmeur) 
             values('$description', $id_question, $id_programmeur) ";
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