<?php
  // -- PAGE commande.detail  detail ( AFFICHER un détail COMMANDE )  --
  $index = true;      
   include_once("_connexion.php");
   // inclure le header dans toutes les PAGES; MAIS dans le GET: avec la navigation NAV -->
   // FERMER: ---------------- ----------------------------------------------------------- Déclenché par (e) le POST
   //                   donc: quand on POST le formulaire, click (e) sur bouton submit [FERMER] en bas de formulaire   
   if($_POST){     
     $commande = false;      
     header("Location: index.php"); // REDIRECTION sur la PAGE Commandes     
     exit();
   }
   // FERMER le if du POST id (commande à MODIFIER)------------------------------------------------------------- POST

  
  // récupérer l'id du article à MODIFIER -------------------------------------------------- Déclenché par (e) le GET
  //         donc quand on GET (demande) le formulaire, quand je clique (e) sur bouton MODIFIER de la liste commandes
  if(!empty($_GET["id"])){
    include_once("header.php"); // inclure le header dans toutes les PAGES: avec la navigation NAV -->
    $GLOBALS['information_message'] = "";
    $GLOBALS['connexion_message'] = "";    
    // récupérer toutes les informations de la commande---------------------------------
    $le_SQL = "SELECT a.idcommande,
       a.libellecommande,
       a.nombredevues,
       c.nom,
       c.telephone,
       c.ville,
       a.datecommande,
       d.libellearticle,
       b.quantite
     FROM commande as a, ligne_commande as b, client as c, article as d
     WHERE a.idcommande = b.idcommande
     AND a.idclient = c.idclient
     AND b.idarticle = d.idarticle
     AND a.idcommande= :idcommande";
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
    //
    // Mettre à jour le nombre de vues----------------------------------------------------
    $le_SQL = "UPDATE commande SET nombredevues= :nombredevues WHERE idcommande= :idcommande";
    // connect, prepare + bindParam 
    $connexion2 = new connect();
    $requete2 = $connexion2->prepare($le_SQL);
    $requete2 -> bindParam(":nombredevues", $nombredevues);
    $requete2 -> bindParam(":idcommande", $idcommande);
    //
    // DONNEES + execute
    $nombredevues = $tabCommande["nombredevues"] + 1 ;
    $idcommande = $_GET["id"];
    $requete2 -> execute();
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
        <div style="float:right;color:blue">    
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
              <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
              <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
          </svg>
          <?php echo $nombredevues; ?>
        </div>
        <h1 class="mt-5">Détail de la commande</h1>

        <!-- FORMULAIRE DE SAISIE DU COMMANDE -->
        <form class="row g-3" method="POST">
          <!-- id caché : on en aura besoin -->
          <input type="hidden"
                 id="idcommande" name="idcommande" Value="<?php echo $tabCommande["idcommande"]?>"/>

          <!-- idclient/datecommande -->
          <div class="col-md-6">
            <!-- idclient : liste déroulante en modification avec un selected -->
            <label for="idclient" class="form-label">ID Client</label>
            <select class="form-control" disabled
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
              <input type="date" class="form-control" placeholder="datecommande" disabled
                    id="datecommande" name="datecommande" Value="<?php echo $tabCommande["datecommande"]?>"/>
          </div>
          <!-- libellecommande seul -->
          <div class="col-12">
            <label for="libellecommande" class="form-label">Libelle Commande</label>
            <input type="text" class="form-control" placeholder="saisir libelle commande" disabled
                  id="libellecommande" name="libellecommande" Value="<?php echo $tabCommande["libellecommande"]?>"/>
          </div>   
          <!-- nom & ville -->
          <div class="col-md-6">
              <!-- nom -->
              <label for="nom" class="form-label">Nom</label>
              <input type="text" class="form-control" placeholder="nom" disabled
                    id="nom" name="nom" Value="<?php echo $tabCommande["nom"]?>"/>
          </div>
          <div class="col-md-6">
              <!-- ville -->
              <label for="ville" class="form-label">Ville</label>
              <input type="text" class="form-control" placeholder="adresse" disabled
                    id="ville" name="ville" Value="<?php echo $tabCommande["ville"]?>"/>
          </div>           
          <!-- libellearticle & quantite -->
          <div class="col-md-6">
              <!-- libellearticle -->
              <label for="libellearticle" class="form-label">Libellé article</label>
              <input type="text" class="form-control" placeholder="nom" disabled
                    id="libellearticle" name="libellearticle" Value="<?php echo $tabCommande["libellearticle"]?>"/>
          </div>
          <div class="col-md-6">
              <!-- quantite -->
              <label for="quantite" class="form-label">Quantité</label>
              <input type="text" class="form-control" placeholder="adresse" disabled
                    id="quantite" name="quantite" Value="<?php echo $tabCommande["quantite"]?>"/>
          </div>                       

          <!-- BOUTON submit: MODIFIER -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary">FERMER</button>
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
