<?php
  // -- PAGE client update ( MODIFIER CLIENT )  --
  $client = true;      
   include_once("_connexion.php");
   // inclure le header dans toutes les PAGES; MAIS dans le GET: avec la navigation NAV -->
   // UPDATE CLIENT : UPDATE ------------------------------------------------------------- Déclenché par (e) le POST
   //                 donc: quand on POST le formulaire, click (e) sur bouton submit [MODIFIER] en bas de formulaire   
   if(!empty($_POST["idclient"])&&
   !empty($_POST["nom"])&&
   !empty($_POST["ville"])&&
   !empty($_POST["telephone"])){
     $le_SQL = "UPDATE client SET nom= :nom, ville= :ville, telephone= :telephone WHERE idclient= :idclient";
     // connect, prepare + bindParam 
     $connexion = new connect();
     $requete = $connexion->prepare($le_SQL);
     $requete -> bindParam(":nom", $nom);
     $requete -> bindParam(":ville", $ville);
     $requete -> bindParam(":telephone", $telephone);
     $requete -> bindParam(":idclient", $idclient);
     //
     // DONNEES + execute
     $nom = $_POST["nom"];
     $ville = $_POST["ville"];
     $telephone = $_POST["telephone"];
     $idclient = $_POST["idclient"];
     $requete -> execute();
     //
     $msg = "le Client a été modifié avec succés.";
     $GLOBALS['information_message'] = $msg;      
     $client = false;      
     header("Location: clients.php"); // REDIRECTION sur la PAGE Clients     
     exit();
   }
   // FERMER le if du POST id (client à MODIFIER)--------------------------------------------------------------- POST

  
  // récupérer l'id du article à MODIFIER -------------------------------------------------- Déclenché par (e) le GET
  //           donc quand on GET (demande) le formulaire, quand je clique (e) sur bouton MODIFIER de la liste clients  
  if(!empty($_GET["id"])){
    include_once("header.php"); // inclure le header dans toutes les PAGES: avec la navigation NAV -->
    $GLOBALS['information_message'] = "";
    $GLOBALS['connexion_message'] = "";    
    //
    $le_SQL = "SELECT * FROM client WHERE idclient= :idclient";
    // connect, prepare + bindParam 
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);
    $requete -> bindParam(":idclient", $idclient);      
    //
    // DONNEES + execute
    $idclient = $_GET["id"];      
    $requete -> execute();
    $tabClient = $requete -> fetch();
?>
    <!-- Begin page content                                            dans le if GET -->
    <main class="flex-shrink-0">
      <div class="container">
        <h1 class="mt-5">Modifier un client</h1>

        <!-- FORMULAIRE DE SAISIE DU CLIENT-->
        <form class="row g-3" method="POST">
          <!-- id caché : on en aura besoin -->
          <input type="hidden"
                 id="idclient" name="idclient" Value="<?php echo $tabClient["idclient"]?>"/>

          <!-- nom/ville cote-à-cote -->
          <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" placeholder="Nom" required
                  id="nom" name="nom" Value="<?php echo $tabClient["nom"]?>"/>
          </div>
          <div class="col-md-6">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control" placeholder="Ville" required
                  id="ville" name="ville" Value="<?php echo $tabClient["ville"]?>"/>
          </div>
          <!-- telephone seul -->
          <div class="col-12">
            <label for="telephone" class="form-label">Telephone</label>
            <input type="text" class="form-control" placeholder="Telephone" required
                  id="telephone" name="telephone" Value="<?php echo $tabClient["telephone"]?>"/>
          </div>

          <!-- BOUTON submit: MODIFIER -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary">MODIFIER</button>
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
  // FERMER le if du GET id (client à MODIFIER)----------------------------------------------------------------- GET  
  } 
?>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
