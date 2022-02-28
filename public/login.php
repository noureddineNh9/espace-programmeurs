<?php
   session_start();
   if (isset($_SESSION['loginEmail'])) {
      header('location: index.php');
   }
?>

<?php include './layouts/header.php' ?>


<div class="login__page">
   <div class="left__part p-8">
      <div class="container">
         <h1>Welcome</h1>
         <p>L'objectif de ce site est de faire partager et
            de diffuser très facilement les cours enseignés
            de la filière Sciences Mathématiques et informatique (SMI)
            au niveau de la Faculté des Sciences AÏN CHOK (FSAC) , Université
            HASSAN II (UH2) . </p>
         <button onclick="window.location.href='./signup.php'">Sign in</button>
      </div>
   </div>
   <div class="right__part flex items-center justify-center p-8">
      <div class="">
         <h1>login</h1>
         <form id="login-form" method="POST" action="#" enctype="multipart/form-data">

            <div id="error-text"
               class="hidden max-w-xl mx-auto border rounded-lg border-red-500 text-red-500 bg-red-100 text-center p-2 mb-8">
               error form submition
            </div>
            <input class="border border-gray-600 rounded-md w-full py-2 px-3 mb-6" type="text" name="email"
               placeholder="email">
            <input class="border border-gray-600 rounded-md w-full py-2 px-3 mb-6" type="text" name="password"
               placeholder="password">

            <button class="my-4" type="submit">login</button>

         </form>
      </div>
   </div>
</div>

<?php include './layouts/footer.php' ?>

<script>
const loginForm = $("#login-form");
const loginFormBtn = $("#login-form button");
const loginFormError = $("#login-form #error-text");

loginForm.submit((e) => {
   e.preventDefault();
});

loginFormBtn.click(() => {
   console.log('aze');
   let formData = new FormData(loginForm[0]);
   let xhr = new XMLHttpRequest();

   xhr.open("post", "../api/login.php");
   xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            if (data == "success") {
               location.href = "index.php";
            } else {
               loginFormError.removeClass("hidden");
               loginFormError.text(data);
            }
         }
      }
   };
   xhr.send(formData);
});
</script>