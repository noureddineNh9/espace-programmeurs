<?php

   class programmeur{
      
      public $id;
      public $nom;
      public $prenom;
      public $email;
      public $score;
      public $imageProfile;
   }

   class programmeurController {
      private $conn;


      function __construct($db)
      {
         $this->conn = $db;
      }


      function get($id){
   
         $query = "SELECT * FROM Programmeur WHERE id = $id" ;
         $stmt = $this->conn->prepare($query);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

         $prog = new programmeur();
         $prog->id = $row['id'];
         $prog->nom = $row['nom'];
         $prog->prenom = $row['prenom'];
         $prog->email = $row['email'];
         $prog->score = $row['score'];
         $prog->imageProfile = $row['imageProfile'];

         return $prog;
      }

      function getAll(){
         $query = "SELECT * FROM Programmeur";
         $stmt = $this->conn->prepare($query);
         $stmt->execute();

         $num = $stmt->rowCount();

         $arr=array();
         
         if($num>0){
         
            // products array
            
         
            // retrieve our table contents
            // fetch() is faster than fetchAll()
            // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
               // extract row
               // this will make $row['name'] to
               // just $name only
               extract($row);

               $prog = new programmeur();
         
               
               $prog->id = $id;
               $prog->nom = $nom;
               $prog->prenom = $prenom;
               $prog->email = $email;
               $prog->score = $score;
               $prog->image_profile = $image_profile;

               array_push($arr, $prog);
            }
         
         }

         
         return $arr;
         
      }
   }

?>