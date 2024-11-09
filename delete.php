<?php
  include_once("_connexion.php");
  // récupérer l'id du client à supprimmer
  // DELETE CLIENT : delete ------------------------------------------------------------------------GET
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
      header("Location: clients.php"); // REDIRECTION sur la PAGE Clients
  }
  // DELETE ARTICLE : delete ------------------------------------------------------------------------GET
  if(!empty($_GET["idarticle"])&&
      empty($_GET["idimage"])){
    $le_SQL = "DELETE FROM article WHERE idarticle= :idarticle";
    // connect, prepare + bindParam 
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);
    $requete -> bindParam(":idarticle", $idarticle);      
    //
    // DONNEES + execute
    $idarticle = $_GET["idarticle"];      
    $requete -> execute();
    $requete -> closeCursor();
    header("Location: articles.php"); // REDIRECTION sur la PAGE Articles
  }
  // DELETE IMAGE   : delete ------------------------------------------------------------------------GET
  if(!empty($_GET["idarticle"])&&
     !empty($_GET["idimage"])){
    // SUPPRIMER l'image sur le SERVEUR dans son dossier image-----------(1)
    $le_SQL = "SELECT * FROM image WHERE idimage= :idimage";
    // connect, prepare + bindParam 
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);
    $requete -> bindParam(":idimage", $idimage);      
    //
    // DONNEES + execute
    $idimage = $_GET["idimage"];      
    $tabimage = $requete -> fetch();
    $requete -> closeCursor();
    unlink($tabimage["cheminimage"]); // suppression
    // SUPPRIMER l'image en base de données dans table image ------------(2)
    $le_SQL = "DELETE FROM image WHERE idimage= :idimage";
    // connect, prepare + bindParam 
    $connexion2 = new connect();
    $requete2 = $connexion2->prepare($le_SQL);
    $requete2 -> bindParam(":idimage", $idimage);      
    //
    // DONNEES + execute
    $idimage2 = $_GET["idimage"];      
    $requete2 -> execute();
    $requete2 -> closeCursor();
    header("Location: article.update.php?id=".$_GET["idarticle"]); // REDIRECTION sur la PAGE Article.update ? id
  }
  // DELETE COMMANDE : delete -----------------------------------------------------------------------GET
  if(!empty($_GET["idcommande"])){
    // on supprime d'abord ligne_commande puis ensuit commande
    // ligne_commande ------------------------
    $le_SQL = "DELETE FROM ligne_commande WHERE idcommande= :idcommande";
    // connect, prepare + bindParam 
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);
    $requete -> bindParam(":idcommande", $idcommande);      
    //
    // DONNEES + execute
    $idcommande = $_GET["idcommande"];      
    $requete -> execute();
    $requete -> closeCursor();
    //
    // commande -------------------------------
    $le_SQL = "DELETE FROM commande WHERE idcommande= :idcommande";
    // connect, prepare + bindParam 
    $connexion2 = new connect();
    $requete2 = $connexion2->prepare($le_SQL);
    $requete2 -> bindParam(":idcommande", $idcommande);      
    //
    // DONNEES + execute
    $idcommande = $_GET["idcommande"];      
    $requete2 -> execute();
    $requete2 -> closeCursor();
    header("Location: commandes.php"); // REDIRECTION sur la PAGE Commandes
  }
