<?php
  include_once("_connexion.php");
  // récupérer l'id du client à supprimmer
  // DELETE CLIENT : delete
  if(!empty($_GET["id"])){
      $le_SQL = "DELETE FROM client WHERE idclient= :idclient";
      // connect, prepare + bindParam 
      $connexion = new connect();
      $requete = $connexion->prepare($le_SQL);
      $requete -> bindParam(":idclient", $idclient);      
      //
      // DONNEES + execute
      $idclient = $_GET["id"];      
      $requete -> execute();
      $requete -> closeCursor();
      header("Location: clients.php"); // REDIRECTION sur la PAGE Clients !!!!!!!!!  ça plante
  }
