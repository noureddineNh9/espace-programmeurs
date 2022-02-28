<?php
   session_start();
   
   if (isset($_SESSION['loginEmail'])) {
      session_unset();
      session_destroy();
   }

   header('location: ../public/login.php');

?>