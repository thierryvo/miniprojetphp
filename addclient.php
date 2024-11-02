<?php
   include_once("header.php");
   include_once("_connexion.php");
   // inclure le header dans toutes les PAGES: avec la navigation NAV -->
   // -- PAGE addclient ( SAISIE CLIENT )  --
   $client = true;   
   $GLOBALS['information_message'] = "";
   $GLOBALS['connexion_message'] = "";

   // ADD CLIENT : INSERER ------------------------ Déclenché par le POST
   if(!empty($_POST["nom"])&&
      !empty($_POST["ville"])&&
      !empty($_POST["telephone"])){
      $le_SQL = "INSERT INTO client
      (nom, ville, telephone) 
      VALUES 
      (:nom, :ville, :telephone)";    
      // connect, prepare + bindParam 
      $connexion = new connect();
      $requete = $connexion->prepare($le_SQL);
      $requete -> bindParam(":nom", $nom);
      $requete -> bindParam(":ville", $ville);
      $requete -> bindParam(":telephone", $telephone);
      //
      // DONNEES + execute
      $nom = $_POST["nom"];
      $ville = $_POST["ville"];
      $telephone = $_POST["telephone"];
      $requete -> execute();
      $requete -> closeCursor();

      $msg = "le Client a été ajouté avec succés.";
      $GLOBALS['information_message'] = $msg;      
      $client = false;      
      //             non  header("Location:http://localhost/mini-projet/clients.php"); // REDIRECTION sur la PAGE Clients
      //             non  exit(header("Location:clients.php")); // REDIRECTION sur la PAGE Clients
      //             non  header("Location: clients.php"); // REDIRECTION sur la PAGE Clients !!!!!!!!!  ça plante
      // header("Location: clients.php"); // REDIRECTION sur la PAGE Clients !!!!!!!!!  ça plante 
   }
?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Ajouter un client</h1>

    <!-- FORMULAIRE DE SAISIE DU CLIENT-->
    <form class="row g-3" method="POST">
      <!-- nom/ville cote-à-cote -->
      <div class="col-md-6">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" placeholder="Nom" required
               id="nom" name="nom">
      </div>
      <div class="col-md-6">
        <label for="ville" class="form-label">Ville</label>
        <input type="text" class="form-control" placeholder="Ville" required
               id="ville" name="ville">
      </div>
      <!-- telephone seul -->
      <div class="col-12">
        <label for="telephone" class="form-label">Telephone</label>
        <input type="text" class="form-control" placeholder="Telephone" required
               id="telephone" name="telephone">
      </div>

      <!-- BOUTON submit: AJOUTER -->
      <div class="col-6">
        <button type="submit" class="btn btn-primary">AJOUTER</button>
      </div>
      <div class="col-6">
        <a href="clients.php">
          <button type="button" class="btn btn-primary">RETOUR CLIENT</button>
        </a>
      </div>      
    </form> 
    <!-- -->

  </div>
</main>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
?>
