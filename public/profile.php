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
      }
   }else{
      header("location: login.php");
   }
 

 ?>

<?php include 'layouts/header.php';?>

<h1>profile</h1>

<div class="mx-auto">
   <div class="max-w-2xl">
      <form id="editProfile-form" method="POST" action="#" enctype="multipart/form-data">

         <div id="error-text"
            class="hidden max-w-xl mx-auto border rounded-lg border-red-500 text-red-500 bg-red-100 text-center p-2 mb-8">
            error form submition
         </div>
         <div class="flex">
            <input class="border border-gray-600 rounded-md w-full py-2 px-3 mb-6 mr-4" type="text" name="nom"
               placeholder="nom" value="<?php echo $programmeur->nom ?>">
            <input class="border border-gray-600 rounded-md w-full py-2 px-3 mb-6" type="text" name="prenom"
               placeholder="prenom" value="<?php echo $programmeur->prenom ?>">
         </div>
         <input class=" border border-gray-600 rounded-md w-full py-2 px-3 mb-6" type="text" name="email"
            placeholder="email" value="<?php echo $programmeur->email ?>">

         <button class=" my-4" type="submit">Sign Up</button>

      </form>


   </div>

</div>


<?php  include 'layouts/footer.php' ?>


<script>
const editProfileForm = $("#editProfile-form");
const editProfileFormBtn = $("#editProfile-form button");
const editProfileFormError = $("#editProfile-form #error-text");

editProfileForm.submit((e) => {
   e.preventDefault();
});

editProfileFormBtn.click(() => {
   let formData = new FormData(editProfileForm[0]);
   let xhr = new XMLHttpRequest();

   xhr.open("post", "../api/controllers/programmeur/edit.php");
   xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;

            console.log(data);
         }
      }
   };
   xhr.send(formData);
});
</script>