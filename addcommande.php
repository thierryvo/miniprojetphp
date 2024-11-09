<?php
   include_once("_connexion.php");
   // inclure le header dans toutes les PAGES; MAIS dans le GET: avec la navigation NAV -->
   // -- PAGE addcommande ( SAISIE COMMANDE ) et aussi ( SAISIE ligne_commande )  --
   $commande = true;      
   // ADD COMMANDE : INSERT -------------------------------------------------------------- Déclenché par (e) le POST
   //                  donc: quand on POST le formulaire, click (e) sur bouton submit [AJOUTER] en bas de formulaire   
   if(!empty($_POST["idclient"])&&
      !empty($_POST["datecommande"])&&
      !empty($_POST["libellecommande"])&&
      !empty($_POST["idarticle"])&&
      !empty($_POST["quantite"])){
      // insertion dans: commande -----------------------------
      $le_SQL = "INSERT INTO commande
      (idclient, datecommande, libellecommande) 
      VALUES 
      (:idclient, :datecommande, :libellecommande)";    
      // connect, prepare + bindParam 
      $connexion = new connect();
      $requete = $connexion->prepare($le_SQL);
      $requete -> bindParam(":idclient", $idclient);
      $requete -> bindParam(":datecommande", $datecommande);
      $requete -> bindParam(":libellecommande", $libellecommande);
      //
      // DONNEES + execute
      $idclient = $_POST["idclient"];
      $datecommande = $_POST["datecommande"];
      $libellecommande = $_POST["libellecommande"];
      $requete -> execute();
      $requete -> closeCursor();
      $dernier_idcommande = $connexion -> lastInsertId();   // DERNIER idcommande inséré
      //
      // insertion dans: ligne_commande -----------------------
      $le_SQL = "INSERT INTO ligne_commande
      (idarticle, idcommande, quantite) 
      VALUES 
      (:idarticle, :idcommande, :quantite)";
      // connect, prepare + bindParam 
      $connexion2 = new connect();
      $requete2 = $connexion2->prepare($le_SQL);
      $requete2 -> bindParam(":idarticle", $idarticle);
      $requete2 -> bindParam(":idcommande", $idcommande);
      $requete2 -> bindParam(":quantite", $quantite);
      //
      // DONNEES + execute
      $idarticle = $_POST["idarticle"];
      $idcommande = $dernier_idcommande;                    // DERNIER idcommande inséré
      $quantite = $_POST["quantite"];
      $requete2 -> execute();
      $requete2 -> closeCursor();      

      $msg = "la Commande a été ajouté avec succés.";
      $GLOBALS['information_message'] = $msg;      
      $client = false;            
      header("Location: commandes.php"); // REDIRECTION sur la PAGE Commandes             
      exit();
   }
   // FERMER le if du POST id (commande à AJOUTER)-------------------------------------------------------------- POST   


    // récupérer un get vide qui n existe pas ---------------------------------------------- Déclenché par (e) le GET
    //        donc quand on GET (demande) le formulaire, quand je clique (e) sur bouton AJOUTER de la liste commandes 
    if(empty($_GET["id"])){
      include_once("header.php"); // inclure le header dans toutes les PAGES: avec la navigation NAV -->
      $GLOBALS['information_message'] = "";
      $GLOBALS['connexion_message'] = "";    
      //
      // je fais un get id et je test empty VIDE car je n'ai pas de id en création, pas encore
      // c'est juste pour faire un $_GET  pour rendre mon GET étanche
      //
      // déterminer la liste des clients pour le select (liste déroulante)
      // connect, prepare + execute
      $le_SQL = "SELECT idclient FROM client";
      $connexion = new connect();
      $requete = $connexion->prepare($le_SQL);    
      $requete -> execute();
      $tabClients = $requete -> fetchAll();  // tableau associatif  
      // déterminer la liste des articles pour le select (liste déroulante)
      // connect, prepare + execute
      $le_SQL = "SELECT idarticle FROM article";
      $connexion2 = new connect();
      $requete2 = $connexion2->prepare($le_SQL);    
      $requete2 -> execute();
      $tabArticles = $requete2 -> fetchAll();  // tableau associatif           
?>
      <!-- Begin page content -->
      <main class="flex-shrink-0">
        <div class="container">
          <h1 class="mt-5">Ajouter une commande</h1>

          <!-- FORMULAIRE DE SAISIE DU COMMANDE -->
          <form class="row g-3" method="POST">
            <!-- idclient/datecommande -->
            <div class="col-md-6">
              <!-- idclient : liste déroulante -->
              <label for="idclient" class="form-label">ID Client</label>
              <select class="form-control" required
                      name="idclient" id="idclient">
                <?php 
                // on boucle pour récupérer chaque element client un par un et
                //  CREER une option à chaque ligne
                foreach($tabClients as $tabvalues){
                  foreach($tabvalues as $itemValeur){
                    echo "<option value=" .$itemValeur. ">" .$itemValeur. "</option>";
                  }
                }
                ?>                
              </select>
            </div>            
            <div class="col-md-6">
              <!-- date commande -->
              <label for="datecommande" class="form-label">Date Commande</label>
              <input type="date" class="form-control" placeholder="datecommande" required
                    id="datecommande" name="datecommande"/>
            </div>
            <!-- libellecommande seul -->
            <div class="col-12">
              <label for="libellecommande" class="form-label">Libelle Commande</label>
              <input type="text" class="form-control" placeholder="saisir libelle commande" required
                    id="libellecommande" name="libellecommande"/>
            </div>

            <!-- **************************** PARTIE LIGNE COMMANDE ****************************  -->            
            <div class="col-md-6">
              <!-- idarticle : liste déroulante  -->
              <label for="idarticle" class="form-label">ID ARTICLE</label>
              <select class="form-control" required
                      name="idarticle" id="idarticle">
                <?php 
                // on boucle pour récupérer chaque element article un par un et
                //  CREER une option à chaque ligne
                foreach($tabArticles as $tabvalues){
                  foreach($tabvalues as $itemValeur){
                    echo "<option value=" .$itemValeur. ">" .$itemValeur. "</option>";
                  }
                }
                ?>           
              </select>              
            </div>         
            <div class="col-md-6">
              <!-- quantité -->
              <label for="quantite" class="form-label">Quantité</label>
              <input type="text" class="form-control" placeholder="quantite" required
                    id="quantite" name="quantite"/>
            </div>               


            <!-- BOUTON submit: AJOUTER -->
            <div class="col-6">
              <button type="submit" class="btn btn-primary">AJOUTER</button>
            </div>   
          </form> 
          <!-- -->

        </div>
      </main>
<?php  
  // FERMER le if du GET id (commande à CREER)------------------------------------------------------------------ GET  
  } 
?>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
