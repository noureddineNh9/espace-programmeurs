<?php


session_start();
include_once './database/config.php';


$nom = mysqli_real_escape_string($conn, $_POST['nom']);
$prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($password)){
   $sqlSelect = mysqli_query($conn, "SELECT * FROM Compte WHERE email = '$email'");

   if(mysqli_num_rows($sqlSelect) > 0){
      echo "$email - This email already exist!";
   }else{
      $sql1 = mysqli_query($conn, "INSERT INTO Compte(email, password, type) values('$email', '$password', 'programmeur')");
      if($sql1){
         $sql2 = mysqli_query($conn, "INSERT INTO Programmeur(email, nom, prenom, image_profile) 
                                       values('$email', '$nom', '$prenom', '$new_img_name')");
         if($sql2){
            //$_SESSION['loginId'] = mysqli_insert_id($conn);
            $_SESSION['loginEmail'] = $email;

            echo 'success';
         }else{
            echo "Something went wrong. Please try again!";
         }
      }else{
         echo "Something went wrong. Please try again!";
      }


      

   }
}else {
   echo 'form not valide';
}

?>