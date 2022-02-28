<?php 
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Headers: access");
   header("Access-Control-Allow-Methods: GET");
   header("Access-Control-Allow-Credentials: true");
   header('Content-Type: application/json');

   include_once '../../config/database.php';
   include_once '../../models/etudiant.php';

   $database = new Database();
   $db = $database->getConnection();

   $etudiant = new Etudiant($db);

   $etudiant->id = isset($_GET['id']) ? $_GET['id'] : die();

   $etudiant->get();

   if($etudiant->nom != null){
      $etudiant_arr = array(
         "id" => $etudiant->id,
         "nom" => $etudiant->nom,
         "prenom" => $etudiant->prenom,
         "score" => $etudiant->score,
         "image_profile" => $etudiant->image_profile,
      );

      http_response_code(200);

      echo json_encode($etudiant_arr);
   }else{
      http_response_code(404);
  
      // tell the user product does not exist
      echo json_encode(array("error" => "Product does not exist."));
   }

?>