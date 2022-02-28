<?php include './layouts/header.php' ?>

<?php include './layouts/sidebar.php';?>



<div class="content questions__page p-8">
   <?php
   include '../api/models/question.php';
   $questions_arr = array();

   // selectionner tout les questions
   $query = "SELECT q.id, q.titre, q.description, p.nom , p.prenom , p.image_profile
             FROM Programmeur p JOIN Question q WHERE p.id = q.id_programmeur";
   $res = mysqli_query($conn, $query);
   if (mysqli_num_rows($res) > 0) {
      while($row = mysqli_fetch_assoc($res)){
         
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
         array_push($questions_arr, $question);
      }
   }
?>
   <div class="flex justify-between mb-12">
      <button id="show-question-modal" class="button__2">poser une question</button>
   </div>
   <div class="questions__container mx-auto border p-10">

      <?php
         foreach ($questions_arr as $item) {
            echo "
            <div class='questions__item'>
               <div class='question__content border p-6 mb-4 rounded-xl'>
                  <div class='flex justify-between'>
                     <div class='flex items-end mb-4'>
                        <img class='w-10 h-10 rounded-full border  border-blue-300 object-cover mr-4'
                           src='$item->programmeurImage' />
                        <p>$item->programmeurName</p>
                     </div>
                     <a class='link__2' href='question.php?id=$item->id'>repondu => </a>
                  </div>

                  <h4 class='mb-4 question__title'>
                     $item->titre
                  </h4>
                  <p class='mb-8 question__description'>local {
                     $item->description
                  </p>
                  <div class='flex justify-end'>
                     <span class=''><i>asked 3 mins ago</i></span>
                  </div>
               </div> 
               <div class='ml-24'>
               ";

            if (count( $item->reponses) > 0) {
               $nb = count( $item->reponses);
               echo "<h5 class='mb-4'>$nb reponses</h5>";
               
               // afficher la premier reponse
               $prog_name = $item->reponses[0]['programmeurName'];
               $img = $item->reponses[0]['programmeurImage'];
               $desc = $item->reponses[0]['description'];
               echo "<div class='answer border-b pb-2 mb-6'>
                        <div class='flex items-end mb-2'>
                           <img class='w-10 h-10 rounded-full border border-blue-300 object-cover mr-4'
                              src='$img' />
                           <span>$prog_name</span>
                        </div>
                        <p class='answer__description'>$desc</p>
                     </div>
               ";   
               
               
            }else{
               echo "<h5 class='border-b pb-2 mb-6'>pas de reponses</h5>";
            }

            echo "
               <div class='pb-4 mb-6 text-center'>
                  <a class='link' href='question.php?id=$item->id'>plus des details</a>
               </div>
            ";

            echo "
               </div>
            </div>";
         }
      ?>

   </div>
</div>

<!-- Add question Modal -->
<div id="question-modal" class="modal__1">
   <div class="modal-background">
      <div class="modal">
         <div class="modal__content">
            <button id="close"></button>
            <div class="p-8">
               <form id="add-question-form" action="#">
                  <div id="error-text"
                     class="hidden max-w-xl mx-auto border rounded-lg border-red-500 text-red-500 bg-red-100 text-center p-2 mb-8">
                     error form submition
                  </div>
                  <input hidden type="number" value="<?php echo $programmeur->id ?>" name="id_programmeur" />
                  <input class="form-control" type="text" placeholder="question" name="titre" />
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
$('#show-question-modal').click(function() {
   $('#question-modal').removeClass('out').addClass("active");
   $('body').addClass('modal-active');
})
$('#question-modal #close').click(function() {
   $('#question-modal').addClass("out");
   $('body').removeClass('modal-active');
})
const addQuestionForm = $("#add-question-form");
const addQuestionFormBtn = $("#add-question-form #submit");
const addQuestionFormError = $("#add-question-form #error-text");

addQuestionForm.submit((e) => {
   e.preventDefault();
});

addQuestionFormBtn.click(() => {
   let formData = new FormData(addQuestionForm[0]);

   let xhr = new XMLHttpRequest();

   xhr.open("post", "../api/controllers/question/add.php");
   xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            console.log(data);
            if (data == "success") {
               location.href = "./questions.php";
            } else {
               addQuestionFormError.removeClass("hidden");
               addQuestionFormError.text(data);
            }
         }
      }
   };


   xhr.send(formData);
});

////////////////////////////////////////
</script>