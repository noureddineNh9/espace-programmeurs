<?php 

   session_start();


   if(isset($_SESSION['loginEmail'])){
      include_once '../api/database/config.php';
      include_once '../api/models/programmeur.php';
      $loginEmail = $_SESSION['loginEmail'];
      $sql = mysqli_query($conn, "select * from Programmeur WHERE email = '$loginEmail' ");
      if(mysqli_num_rows($sql) > 0){
         $row = mysqli_fetch_assoc($sql);
         $programmeur = new programmeur();
         $programmeur->id = $row['id'];
         $programmeur->nom = $row['nom'];
         $programmeur->prenom = $row['prenom'];
         $programmeur->email = $row['email'];
         $programmeur->image_profile = $row['image_profile'];
      }else{
         header("location: login.php");
      }
   }else{
      header("location: login.php");
   }
 

 ?>

<input class="toggle__checkbox" type="checkbox" id="toggle-sidebar">
<label id="sidebar-button" class="sidebar__button" for="toggle-sidebar">
   <span class="sidebar__icon"></span>
</label>
<div class="sidebar border-r bg-gray-100 h-screen p-6">
   <div class="flex justify-center mb-4">
      <img class="w-32 h-32 rounded-full border border-blue-300 object-cover"
         src="<?php echo $programmeur->image_profile ?>" />
   </div>

   <h4 class="text-center mb-8"><?php echo ($programmeur->nom . ' ' . $programmeur->prenom) ?></h4>
   <ul class="menu__list">
      <a href="./profile.php">
         <li class="menu__item"><i class="fas fa-user"></i> Profile</li>
      </a>
      <a href="#">
         <li class="menu__item">Home</li>
      </a>
      <a href="#">
         <li class="menu__item">Chat</li>
      </a>
      <a href="./questions.php">
         <li class="menu__item"><i class="fa-solid fa-comment-question"></i> Questions</li>
      </a>
      <a href="#">
         <li class="menu__item">Community</li>
      </a>
      <a href="#">
         <li class="menu__item">Email</li>
      </a>
      <a href="../api/logout.php">
         <li class="menu__item"><i class="fas fa-sign-out-alt"></i> log out</li>
      </a>
   </ul>
</div>