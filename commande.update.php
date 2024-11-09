<?php
  // -- PAGE commande update ( MODIFIER COMMANDE )  --
  $commande = true;      
   include_once("_connexion.php");
   // inclure le header dans toutes les PAGES; MAIS dans le GET: avec la navigation NAV -->
   // UPDATE COMMANDE : UPDATE ----------------------------------------------------------- Déclenché par (e) le POST
   //                 donc: quand on POST le formulaire, click (e) sur bouton submit [MODIFIER] en bas de formulaire   
   if(!empty($_POST["idcommande"])&&
   !empty($_POST["idclient"])&&
   !empty($_POST["datecommande"])&&
   !empty($_POST["libellecommande"])){
     $le_SQL = "UPDATE commande SET idclient= :idclient, datecommande= :datecommande, libellecommande= :libellecommande WHERE idcommande= :idcommande";
     // connect, prepare + bindParam 
     $connexion = new connect();
     $requete = $connexion->prepare($le_SQL);
     $requete -> bindParam(":idclient", $idclient);
     $requete -> bindParam(":datecommande", $datecommande);
     $requete -> bindParam(":libellecommande", $libellecommande);
     $requete -> bindParam(":idcommande", $idcommande);
     //
     // DONNEES + execute
     $idclient = $_POST["idclient"];
     $datecommande = $_POST["datecommande"];
     $libellecommande = $_POST["libellecommande"];
     $idcommande = $_POST["idcommande"];
     $requete -> execute();
     //
     $msg = "la commande a été modifié avec succés.";
     $GLOBALS['information_message'] = $msg;      
     $commande = false;      
     header("Location: commandes.php"); // REDIRECTION sur la PAGE Commandes     
     exit();
   }
   // FERMER le if du POST id (commande à MODIFIER)------------------------------------------------------------- POST

  
  // récupérer l'id du article à MODIFIER -------------------------------------------------- Déclenché par (e) le GET
  //         donc quand on GET (demande) le formulaire, quand je clique (e) sur bouton MODIFIER de la liste commandes
  if(!empty($_GET["id"])){
    include_once("header.php"); // inclure le header dans toutes les PAGES: avec la navigation NAV -->
    $GLOBALS['information_message'] = "";
    $GLOBALS['connexion_message'] = "";    
    //
    $le_SQL = "SELECT * FROM commande WHERE idcommande= :idcommande";
    // connect, prepare + bindParam 
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);
    $requete -> bindParam(":idcommande", $idcommande);      
    //
    // DONNEES + execute
    $idcommande = $_GET["id"];      
    $requete -> execute();
    $tabCommande = $requete -> fetch();         // tableau associatif de la COMMANDE
    //
    // déterminer la liste des clients pour le select (liste déroulante)
    // connect, prepare + execute
    $le_SQL = "SELECT idclient FROM client";
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);    
    $requete -> execute();
    $tabClients = $requete -> fetchAll();       // tableau associatif       
?>
    <!-- Begin page content                                                                        dans le if GET -->
    <main class="flex-shrink-0">
      <div class="container">
        <h1 class="mt-5">Modifier une commande</h1>

        <!-- FORMULAIRE DE SAISIE DU COMMANDE -->
        <form class="row g-3" method="POST">
          <!-- id caché : on en aura besoin -->
          <input type="hidden"
                 id="idcommande" name="idcommande" Value="<?php echo $tabCommande["idcommande"]?>"/>

          <!-- idclient/datecommande -->
          <div class="col-md-6">
            <!-- idclient : liste déroulante en modification avec un selected -->
            <label for="idclient" class="form-label">ID Client</label>
            <select class="form-control" required
                    name="idclient" id="idclient">
              <?php 
              // on boucle pour récupérer chaque element client un par un et
              //  CREER une option à chaque ligne
              foreach($tabClients as $tabvalues){
                foreach($tabvalues as $itemValeur){
                  if($tabCommande["idclient"] == $itemValeur){
                    // on est sur l'ID client de la BDD
                    $selected="selected";
                  }else{
                    // les autres choix:
                    $selected="";                    
                  } 
                  echo "<option value=" .$itemValeur. " " .$selected. ">" .$itemValeur. "</option>";                 
                }
              }
              ?>                
            </select>
          </div>     
          <div class="col-md-6">
              <!-- date commande -->
              <label for="datecommande" class="form-label">Date Commande</label>
              <input type="date" class="form-control" placeholder="datecommande" required
                    id="datecommande" name="datecommande" Value="<?php echo $tabCommande["datecommande"]?>"/>
          </div>
          <!-- libellecommande seul -->
          <div class="col-12">
            <label for="libellecommande" class="form-label">Libelle Commande</label>
            <input type="text" class="form-control" placeholder="saisir libelle commande" required
                  id="libellecommande" name="libellecommande" Value="<?php echo $tabCommande["libellecommande"]?>"/>
          </div>                         

          <!-- BOUTON submit: MODIFIER -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary">MODIFIER</button>
          </div>     
        </form> 
        <!-- -->

      </div>
    </main>

<?php
  // FERMER le if du GET id (commande à MODIFIER)--------------------------------------------------------------- GET    
  } 
?>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
