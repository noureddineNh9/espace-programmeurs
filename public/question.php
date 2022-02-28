<?php include './layouts/header.php' ?>
<?php include './layouts/sidebar.php';?>

<div class="content question__page">

   <?php
      if(isset($_GET['id'])){
         include_once '../api/database/config.php';
         include_once '../api/models/question.php';
         $questionId = $_GET['id'];
         $query = "SELECT q.id, q.titre, q.description, p.nom , p.prenom , p.image_profile
                   FROM Programmeur p JOIN Question q 
                   WHERE p.id = q.id_programmeur AND q.id = $questionId";
         $res = mysqli_query($conn, $query);
         if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            $question = new question();
            $question->id = $row['id'];
            $question->titre = $row['titre'];
            $question->description = $row['description'];
            $question->programmeurName = $row['nom'] . ' ' . $row['prenom'];
            $question->programmeurImage = $row['image_profile'];
   
            // selectionner les reponses associe a chaque question. 
            $query2 = "SELECT r.id, r.description, p.nom , p.prenom , p.image_profile
                       FROM Reponse r JOIN Programmeur p
                       WHERE r.id_programmeur = p.id AND r.id_question = $question->id";
            $res2 = mysqli_query($conn, $query2);
            if (mysqli_num_rows($res2) > 0) {
               $reponses_arr = array();
               while($row2 = mysqli_fetch_assoc($res2)){
                  $reponse = array(
                     "id" => $row2['id'],
                     "description" => $row2['description'],
                     "programmeurName" => $row2['nom'] . ' ' . $row2['prenom'],
                     "programmeurImage" => $row2['image_profile']
                  );
                  array_push($reponses_arr, $reponse);
               }
               $question->reponses = $reponses_arr;
            }
         }else{
            header("location: questions.php");
         }
      }else{
         header("location: questions.php");
      }
   ?>


   <div class="questions__container mx-auto p-10">

      <div class='questions__item'>
         <div class='question__content border p-6 mb-4 rounded-xl'>
            <div class='flex justify-between'>
               <div class='flex questions-end mb-4'>
                  <img class='w-10 h-10 rounded-full border  border-blue-300 object-cover mr-4'
                     src='<?php echo $question->programmeurImage; ?>' />
                  <p><?php echo $question->programmeurName; ?></p>
               </div>
               <button onclick='repondu(<?php echo $question->id; ?>)' class='repondu__button'>répondu</button>
            </div>

            <h4 class='mb-4 question__title'>
               <?php echo $question->titre; ?>
            </h4>
            <p class='mb-8 question__description'>local {
               <?php echo $question->description; ?>
            </p>
            <div class='flex justify-end'>
               <span class=''><i>asked 3 mins ago</i></span>
            </div>
         </div>
         <div class='ml-24'>
            <?php 
               if (count( $question->reponses) > 0) {
                  $nb = count( $question->reponses);
                  echo "<h5 class='mb-4'>$nb reponses</h5>";
                  foreach($question->reponses as $rep){
                     $prog_name = $rep['programmeurName'];
                     $img = $rep['programmeurImage'];
                     $desc = $rep['description'];
                     echo "<div class='answer border-b pb-2 mb-6'>
                              <div class='flex questions-end mb-2'>
                                 <img class='w-10 h-10 rounded-full border border-blue-300 object-cover mr-4' src='$img' />
                                 <span>$prog_name</span>
                              </div>
                              <p class='answer__description'>$desc</p>
                           </div>
                           ";
   
                  }

                  // afficher la premier reponse


               }else{
                  echo "<h5 class='border-b pb-2 mb-6'>pas de reponses</h5>";
               }

               echo "
                   </div>
               </div>";
            ?>
         </div>
      </div>
   </div>
</div>

<!-- reponse Modal -->
<div id="reponse-modal" class="modal__1">
   <div class="modal-background">
      <div class="modal">
         <div class="modal__content ">
            <button id="close"></button>
            <div class="p-8 ">
               <form id="add-reponse-form" action="#">
                  <div id="error-text"
                     class="hidden max-w-xl mx-auto border rounded-lg border-red-500 text-red-500 bg-red-100 text-center p-2 mb-8">
                     error form submition
                  </div>
                  <input hidden type="number" value="0" name="id_question" />
                  <input hidden type="number" value="<?php echo $programmeur->id ?>" name="id_programmeur" />
                  <textarea class="form-control" placeholder="details" name="description" rows="8"></textarea>
                  <button id="submit">ajouter</button>
               </form>

            </div>
         </div>
         <svg class="modal-svg" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
            preserveAspectRatio="none">
            <rect x="0" y="0" fill="none" width="100%" height="100%" rx="3" ry="3"></rect>
         </svg>


      </div>
   </div>
</div>


<?php include './layouts/footer.php' ?>




<script>
function repondu(id) {
   console.log('reponse' + id);
   $('#add-reponse-form input[name="id_question"]').val(id);

}

$('.repondu__button').click(function() {
   $('#reponse-modal').removeClass('out').addClass("active");
   $('body').addClass('modal-active');
})

$('#reponse-modal #close').click(function() {
   $('#reponse-modal').addClass("out");
   $('body').removeClass('modal-active');
})


const addReponseForm = $("#add-reponse-form");
const addReponseBtn = $("#add-reponse-form #submit");
const addReponseError = $("#add-reponse-form #error-text");

addReponseForm.submit((e) => {
   e.preventDefault();
});

addReponseBtn.click(() => {
   let formData = new FormData(addReponseForm[0]);

   let xhr = new XMLHttpRequest();

   xhr.open("post", "../api/controllers/reponse/add.php");
   xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            if (data == "success") {
               location.reload();
            } else {
               addReponseError.removeClass("hidden");
               addReponseError.text(data);
            }
         }
      }
   };


   xhr.send(formData);
});
</script>