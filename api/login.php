<?php

session_start();
include_once './database/config.php';


$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($email) && !empty($password)){
   $sqlSelect = mysqli_query($conn, "SELECT * FROM Compte WHERE email = '$email'");

   if(mysqli_num_rows($sqlSelect) == 0){
      echo "$email - This email not exist!";
   }else{
      if($row = mysqli_fetch_assoc($sqlSelect)){
         if($row['password'] === $password){
            $_SESSION['loginEmail'] = $row['email'];
            echo 'success';
         }else{
            echo 'password incorrect';
         }
      }
   }
}else {
   echo 'form not valide';
}

?>