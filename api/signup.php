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
      // if the user upload image 
      if(isset($_FILES['image_profile']) && $_FILES['image_profile']['size'] != 0){
         $img_name = $_FILES['image_profile']['name'];
         $img_type = $_FILES['image_profile']['type'];
         $tmp_name = $_FILES['image_profile']['tmp_name'];
         
         $img_explode = explode('.',$img_name);
         $img_ext = end($img_explode);

         $extensions = ["jpeg", "png", "jpg"];
         if(in_array($img_ext, $extensions) === true){
            $types = ["image/jpeg", "image/jpg", "image/png"];
            if(in_array($img_type, $types) === true){
               $d = new DateTime();
               $time = $d->format("YmdHisv");
               $new_img_name = "../uploads/images/".$time.".$img_ext";
               if(move_uploaded_file($tmp_name,$new_img_name)){
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
               }else {
                  echo 'error in upload image';
               }
            }else{
                echo "Please upload an image file - jpeg, png, jpg";
            }
         }else{
             echo "Please upload an image file - jpeg, png, jpg";
         }
      }else{
         $new_img_name = "./assets/images/default-img-profile.jpg";
         $sql1 = mysqli_query($conn, "INSERT INTO Compte(email, password, type) values('$email', '$password', 'programmeur')");
         if($sql1){
            $sql2 = mysqli_query($conn, "INSERT INTO Programmeur(email, nom, prenom, image_profile) 
                                          values('$email', '$nom', '$prenom', '$new_img_name')");
            if($sql2){
               $_SESSION['loginId'] = mysqli_insert_id($conn);
               echo 'success';
            }else{
               echo "Something went wrong. Please try again!";
            }
         }else{
            echo "Something went wrong. Please try again!";
         }
      }


      

   }
}else {
   echo 'form not valide';
}

?>