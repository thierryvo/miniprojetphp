<!DOCTYPE html>
<html lang="">
  <head>       
    <title>CREATION des tables de la base gestioncommandes</title>
  </head>

  <body>
    <!-- body -->
    <h1>CREATION des tables de la base gestioncommandes</h1>
    <p>
      Prérequis pour le minitp, <br />
      CREER manuellement la BDD gestioncommandes, CREER les tables, alimenter les tables
    </p>

	<?php
    $nom_fonction = "";
    echo ".<br/>";
    echo "Tentative de connexion ------------  <br/>";
    // Information de connexion BASE DE DONNEES: phpMyAdmin/MariaDB
    $dbserveur = "localhost";
    $dbport=3307;
    $dbname="gestioncommandes";     // nom de la base : test
    $dbuser = "root";   // nom user root  : root
    $dbpasse = "";      // mot de passe   : BLANC
    // CONNEXION
    $etape = "01";      // -------------------------------    01 ------------------------------------
    switch($etape){
      case "01":
        // CREATION + connexion
        try{  
          $connexion = new PDO('mysql:host='.$dbserveur.';port='.$dbport, $dbuser, $dbpasse);
          $connexion->exec("SET CHARACTER SET utf8");
          $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "CONNEXION à la base de données réussie.";
        
          // Utiliser test2
          $le_SQL = "USE gestioncommandes";
          $connexion -> exec($le_SQL);
          echo "base de données gestioncommandes utilisé.<br/>";      
    
          // CREER une table article
          echo "Tentative de CREER la table article ------------  <br/>";
          $le_SQL = "CREATE TABLE article(
           idarticle INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
           libellearticle VARCHAR(250),
           prix_unitaire FLOAT           
          )";
          $connexion -> exec($le_SQL);
          echo "table article créé avec SUCCES.<br/>";
          
          // CREER une table client
          echo "Tentative de CREER la table client ------------  <br/>";
          $le_SQL = "CREATE TABLE client(
           idclient INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
           nom VARCHAR(30),
           ville VARCHAR(30),
           telephone VARCHAR(20)                    
          )";
          $connexion -> exec($le_SQL);
          echo "table client créé avec SUCCES.<br/>";               
    
          // CREER une table commande
          echo "Tentative de CREER la table commande ------------  <br/>";
          $le_SQL = "CREATE TABLE commande(
           idcommande INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
           idclient INT,
           datecommande date,
           libellecommande VARCHAR(75)
          )";
          $connexion -> exec($le_SQL);
          echo "table commande créé avec SUCCES.<br/>";    
          
          // CREER une table ligne_commande
          echo "Tentative de CREER la table ligne_commande ------------  <br/>";
          $le_SQL = "CREATE TABLE ligne_commande(
           idarticle INT NOT NULL,
           idcommande INT NOT NULL,
           quantité INT,
           PRIMARY KEY (idarticle, idcommande)
          )";
          $connexion -> exec($le_SQL);
          echo "table ligne_commande créé avec SUCCES.<br/>";              
        }
        catch(PDOException $e){
          echo "ECHEC de la connexion BDD gestioncommandes" .$e->getMessage().'<br/>';
        }
        //
        break;
      default:
        break;
    }//FIN: switch case etape 01/02


    $etape = "03";      // -------------------------------    03 ------------------------------------
    switch($etape){
      case "03":        
        try{          
          // 3 ---------------------------------------
          // INSERER:  INSERT INTO + prepare + execute          
          $le_SQL = "INSERT INTO article
          (libellearticle, prix_unitaire) 
          VALUES 
          (:libellearticle, :prix_unitaire)";    
          // prepare + bindParam 
          $requete = $connexion->prepare($le_SQL);
          $requete -> bindParam(":libellearticle", $libellearticle);
          $requete -> bindParam(":prix_unitaire", $prix_unitaire);          
          //
          // DONNEES + execute
          $libellearticle="IMPRIMANTE CANON";
          $prix_unitaire=30;          
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans article; Avec succés.<br/>";       

          $libellearticle="IMPRIMANTE EPSON";
          $prix_unitaire=35;          
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans article; Avec succés.<br/>";        
          
          $libellearticle="CARTOUCHES CANON 4 couleurs";
          $prix_unitaire=145;          
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans article; Avec succés.<br/>";    
          
          $libellearticle="CARTOUCHES EPSON 4 couleurs";
          $prix_unitaire=165;          
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans article; Avec succés.<br/>";         
          
          
          // INSERER
          $le_SQL = "INSERT INTO client
          (nom, ville, telephone) 
          VALUES 
          (:nom, :ville, :telephone)";    
          // prepare + bindParam 
          $requete = $connexion->prepare($le_SQL);
          $requete -> bindParam(":nom", $nom);
          $requete -> bindParam(":ville", $ville);          
          $requete -> bindParam(":telephone", $telephone);    
          //
          // DONNEES + execute
          $nom="THIERRY VOZELLE";
          $ville="BRUGES";          
          $telephone="0555311590";    
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans client; Avec succés.<br/>";

          $nom="LAURA MOREAU";
          $ville="NICES";          
          $telephone="0555341591";    
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans client; Avec succés.<br/>";    
          
          
          // INSERER
          $le_SQL = "INSERT INTO commande
          (idclient, datecommande, libellecommande) 
          VALUES 
          (:idclient, :datecommande, :libellecommande)";    
          // prepare + bindParam 
          $requete = $connexion->prepare($le_SQL);          
          $requete -> bindParam(":idclient", $idclient);          
          $requete -> bindParam(":datecommande", $datecommande);    
          $requete -> bindParam(":libellecommande", $libellecommande);    
          //
          // DONNEES + execute          
          $idclient=1;          
          $datecommande="20241101164500";    
          $libellecommande="Commande de Thierry";    
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans commande; Avec succés.<br/>";
          
          $idclient=2;          
          $datecommande="20241101164600";    
          $libellecommande="Commande de Laura";    
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans commande; Avec succés.<br/>";      
          
          
          // INSERER
          $le_SQL = "INSERT INTO ligne_commande
          (idarticle, idcommande, quantité) 
          VALUES 
          (:idarticle, :idcommande, :quantité)";    
          // prepare + bindParam 
          $requete = $connexion->prepare($le_SQL);          
          $requete -> bindParam(":idarticle", $idarticle);          
          $requete -> bindParam(":idcommande", $idcommande);    
          $requete -> bindParam(":quantité", $quantite);    
          //
          // DONNEES + execute          
          $idarticle=1;          
          $idcommande=1;    
          $quantite=1;    
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans ligne_commande; Avec succés.<br/>";      
          $idarticle=2;          
          $idcommande=1;    
          $quantite=1;    
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans ligne_commande; Avec succés.<br/>";          
          $idarticle=3;          
          $idcommande=2;    
          $quantite=1;    
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans ligne_commande; Avec succés.<br/>";                    
          $idarticle=4;          
          $idcommande=2;    
          $quantite=1;    
          $requete -> execute();
          echo "<br/>1 ENREG. insérés dans ligne_commande; Avec succés.<br/>";                              


        }
        catch(PDOException $e){
          echo "ECHEC à l'INSERTION BDD " .$e->getMessage().'<br/>';
        }                
        break;       
      default:
        break;
    }//FIN: switch case etape 03/04

  
    // FERMER la connexion:
    // $connexion = null;

    // ____________________________________________________


    // ================== FONCTIONS =======================  
    // affFonction -----
    function Division($xx, $yy){
      $nomfct = "constante __FUNCTION__ : " .__FUNCTION__. '<br/>';
      $GLOBALS['nom_fonction'] = $nomfct;
      // THROW=Lancer: Lancer l'interception de l'erreur
      if($yy == 0){
        throw new Exception("Division par zéro impossible");
      }
      // RETOUR
      return $xx/$yy;     
    }    
  ?>
  <!-- Pied de page -->
  <?php include "footer.php";
  ?>

  </body>
</html>
