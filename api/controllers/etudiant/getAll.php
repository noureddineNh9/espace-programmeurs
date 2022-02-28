<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../../config/database.php';
include_once '../../models/etudiant.php';
  
$database = new Database();
$db = $database->getConnection();

$etudiant = new Etudiant($db);
$stmt = $etudiant->getAll();
$num = $stmt->rowCount();


if($num>0){
  
    // products array
    $etudiants_arr=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $etudiant_item=array(
            "id" => $id,
            "nom" => $nom,
            "prenom" => $prenom,
            "score" => $score,
            "image_profile" => $image_profile
        );
  
        array_push($etudiants_arr, $etudiant_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($etudiants_arr);
}else{
  
   // set response code - 404 Not found
   http_response_code(404);
 
   // tell the user no products found
   echo json_encode(
       array("error" => "No products found.")
   );
}