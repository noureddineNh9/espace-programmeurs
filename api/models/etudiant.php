<?php

class Etudiant {
  
   // database connection and table name
   private $conn;
   private $table_name = "Etudiant";

   // object properties
   public $id;
   public $nom;
   public $prenom;
   public $score = 0;
   public $image_profile;

   // constructor with $db as database connection
   public function __construct($db){
      $this->conn = $db;
   }

   // read products
   function getAll(){
   
      // select all query
      $query = "SELECT id, nom, prenom, score, image_profile
                  FROM " . $this->table_name;
   
      // prepare query statement
      $stmt = $this->conn->prepare($query);
   
      // execute query
      $stmt->execute();
   
      return $stmt;
   }

   function get(){
      $query = "SELECT id, nom, prenom, score, image_profile
      FROM " . $this->table_name . " WHERE id = ?" ;

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->id);

      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row['id'];
      $this->nom = $row['nom'];
      $this->prenom = $row['prenom'];
      $this->score = $row['score'];
      $this->image_profile = $row['image_profile'];
   }

   function post(){
  
      // query to insert record
      $query = "INSERT INTO " . $this->table_name . "
              SET nom=:nom, prenom=:prenom, image_profile=:image_profile";
    
      // prepare query
      $stmt = $this->conn->prepare($query);
    
      // sanitize
      $this->nom=htmlspecialchars(strip_tags($this->nom));
      $this->prenom=htmlspecialchars(strip_tags($this->prenom));
      $this->image_profile=htmlspecialchars(strip_tags($this->image_profile));
    
      // bind values
      $stmt->bindParam(":nom", $this->nom);
      $stmt->bindParam(":prenom", $this->prenom);
      $stmt->bindParam(":image_profile", $this->image_profile);
    
      // execute query
      if($stmt->execute()){
          return true;
      }
    
      return false;   
   }


   function put(){
  
      // query to insert record
      $query = "UPDATE  " . $this->table_name . "
              SET nom=:nom, prenom=:prenom,score=:score , image_profile=:image_profile 
              WHERE id=:id";
    
      // prepare query
      $stmt = $this->conn->prepare($query);
    
      // sanitize
      $this->id=htmlspecialchars(strip_tags($this->id));
      $this->nom=htmlspecialchars(strip_tags($this->nom));
      $this->prenom=htmlspecialchars(strip_tags($this->prenom));
      $this->score=htmlspecialchars(strip_tags($this->score));
      $this->image_profile=htmlspecialchars(strip_tags($this->image_profile));
    
      // bind values
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":nom", $this->nom);
      $stmt->bindParam(":prenom", $this->prenom);
      $stmt->bindParam(":score", $this->score);
      $stmt->bindParam(":image_profile", $this->image_profile);
    
      // execute query
      if($stmt->execute()){
          return true;
      }
    
      return false;   
   }


   function delete(){
  
      // query to insert record
      $query = "DELETE FROM " . $this->table_name . " WHERE id=?";
    
      // prepare query
      $stmt = $this->conn->prepare($query);
    
      // sanitize
      $this->id=htmlspecialchars(strip_tags($this->id));
    
      // bind values
      $stmt->bindParam(1, $this->id);
    
      // execute query
      if($stmt->execute()){
          return true;
      }
    
      return false;   
   }
}

?>