<?php
   session_start();
   if (isset($_SESSION['loginEmail'])) {
      header('location: index.php');
   }
?>

<?php include './layouts/header.php' ?>

<?php
/*
   include_once '../api/controllers/programmeurController.php';
   include_once '../api/config/database.php';
   $database = new Database();
   $db = $database->getConnection();
   $progCon = new programmeurController($db);
   $prog = $progCon->getAll();

   print_r($prog);
*/
?>

<div class="signup__container">
   <div class="left__part p-8">
      <div class="container">
         <h1>Welcome</h1>
         <p>L'objectif de ce site est de faire partager et
            de diffuser très facilement les cours enseignés
            de la filière Sciences Mathématiques et informatique (SMI)
            au niveau de la Faculté des Sciences AÏN CHOK (FSAC) , Université
            HASSAN II (UH2) . </p>
         <button onclick="window.location.href='./login.php'">login</button>
      </div>
   </div>
   <div class="right__part flex items-center justify-center p-8">
      <div class="">
         <h1>Create Account</h1>
         <form id="signup-form" method="POST" action="#" enctype="multipart/form-data">

            <div id="error-text"
               class="hidden max-w-xl mx-auto border rounded-lg border-red-500 text-red-500 bg-red-100 text-center p-2 mb-8">
               error form submition
            </div>
            <div class="flex justify-center mb-12">
               <div class="relative img__profile_container">
                  <img id="image-preview" src="./assets/images/default-img-profile.jpg" alt="">
                  <input hidden type="file" name="image_profile" id="image_profile">
                  <label class="edit" for="image_profile"><i class="fas fa-edit"></i></label>
               </div>
            </div>
            <div class="flex">
               <input class="border border-gray-600 rounded-md w-full py-2 px-3 mb-6 mr-4" type="text" name="nom"
                  placeholder="nom">
               <input class="border border-gray-600 rounded-md w-full py-2 px-3 mb-6" type="text" name="prenom"
                  placeholder="prenom">
            </div>
            <input class="border border-gray-600 rounded-md w-full py-2 px-3 mb-6" type="text" name="email"
               placeholder="email">
            <input class="border border-gray-600 rounded-md w-full py-2 px-3 mb-6" type="text" name="password"
               placeholder="password">

            <button class="my-4" type="submit">Sign Up</button>

         </form>
      </div>

   </div>

</div>

<?php include './layouts/footer.php' ?>

<script>
const signupForm = $("#signup-form");
const signupFormBtn = $("#signup-form button");
const signupFormError = $("#signup-form #error-text");

console.log(signupForm);
$("#image_profile").change(function(e) {
   var file = e.target.files[0];
   $("#image-preview").attr("src", URL.createObjectURL(file));
});

signupForm.submit((e) => {
   e.preventDefault();
});

signupFormBtn.click(() => {
   let formData = new FormData(signupForm[0]);

   let xhr = new XMLHttpRequest();

   xhr.open("post", "../api/signup.php");
   xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            if (data == "success") {
               location.href = "index.php";
            } else {
               signupFormError.removeClass("hidden");
               signupFormError.text(data);
            }
         }
      }
   };
   xhr.send(formData);
});
</script>