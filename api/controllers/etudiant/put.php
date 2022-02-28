<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
  
// instantiate etudiant object
include_once '../../models/etudiant.php';
  
$database = new Database();
$db = $database->getConnection();
  
$etudiant = new Etudiant($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
   !empty($data->id) &&   
   !empty($data->nom) &&
    !empty($data->prenom)
){
  
    // set etudiant property values
    $etudiant->id = $data->id;
    $etudiant->nom = $data->nom;
    $etudiant->prenom = $data->prenom;
    $etudiant->score = $data->score;
    $etudiant->image_profile = $data->image_profile;
  
    // create the etudiant
    if($etudiant->put()){

      $etudiant_arr = array(
         "id" => $etudiant->id,
         "nom" => $etudiant->nom,
         "prenom" => $etudiant->prenom,
         "score" => $etudiant->score,
         "image_profile" => $etudiant->image_profile,
      );

      http_response_code(200);

      echo json_encode($etudiant_arr);
  
      // set response code - 201 created

    }
  
    // if unable to create the etudiant, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("error" => "Unable to create etudiant."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("error" => "Unable to create etudiant. Data is incomplete."));
}
?>