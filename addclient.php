<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  // placer le javascript ici:
  // S(document).ready   =>  qui ne s'exécutera que: qand la PAGE DOM sera prête (pour exécution)
  $(document).ready(function(){
    //
    // On va attacher un événement (e) à notre liste déroulante select, son id selectdepartement, (e) = change   
    $("#selectdepartement").on("change", function(){
      //
      // cette fonction s'exécute à chaque changement
      var departement_code = $("#selectdepartement").val(); // code sélectionné dans la liste
      if(!departement_code){
        // N'Existe pas: le code n a pas était sélectionné
        $("#selectville").html("<option value=''>Sélectionner d'abord un département !!!</option>");
      }else{
        // Existe: departement_code a été sélectionné
        // utiliser jquery ajax pour: effectuer une requête http
        $.ajax({
          //
          type: 'POST',
          url:  '_ajaxData.php',
          data: 'departement_code='+departement_code,
          success: function(reponse){
            // fonction qui récupère la réponse, réponse que l'on positionne dans la liste ville: selectville
            // reponse est un ensemble de <option></option>
            $("#selectville").html(reponse);
          }
        });
      }
    });
  });
  // FIN du javascript ------------------------------------------------------------------------------ JAVASCRIPT FIN
</script>
<?php
   include_once("_connexion.php");
   // inclure le header dans toutes les PAGES; MAIS dans le GET: avec la navigation NAV -->
   // -- PAGE addclient ( SAISIE CLIENT )  --
   $client = true;      
   // ADD CLIENT : INSERT ---------------------------------------------------------------- Déclenché par (e) le POST
   //                  donc: quand on POST le formulaire, click (e) sur bouton submit [AJOUTER] en bas de formulaire   
   //                  !empty($_POST["ville"])&&
   if(!empty($_POST["selectville"])&&
      !empty($_POST["nom"])&&
      !empty($_POST["telephone"])){
        //
        // petit SQL pour récupérer la ville depuis son code bof----(1)
        $le_SQL = "SELECT ville_nom FROM villes_france WHERE ville_id= :ville_id";    
        // connect, prepare + bindParam 
        $connexion2 = new connect();
        $requete2 = $connexion2->prepare($le_SQL);
        $requete2 -> bindParam(":ville_id", $ville_id);
        //
        // DONNEES + execute
        $ville_id = $_POST["selectville"]; // ville sélectionné
        $requete2 -> execute();
        $tabVille = $requete2 -> fetch();  // un seul ENREG. dans tableau associatif
        $requete2 -> closeCursor();
        //
        // insert dans client --------------------------------------(2)
      $le_SQL = "INSERT INTO client
      (ville_id, nom, ville, telephone) 
      VALUES 
      (:ville_id, :nom, :ville, :telephone)";    
      // connect, prepare + bindParam 
      $connexion = new connect();
      $requete = $connexion->prepare($le_SQL);
      $requete -> bindParam(":ville_id", $ville_id);
      $requete -> bindParam(":nom", $nom);
      $requete -> bindParam(":ville", $ville);
      $requete -> bindParam(":telephone", $telephone);
      //
      // DONNEES + execute
      $ville_id = $_POST["selectville"]; // ville sélectionné
      $nom = $_POST["nom"];
      $ville = $tabVille["ville_nom"];
      $telephone = $_POST["telephone"];
      $requete -> execute();
      $requete -> closeCursor();

      $msg = "le Client a été ajouté avec succés.";
      $GLOBALS['information_message'] = $msg;      
      $client = false;            
      header("Location: clients.php"); // REDIRECTION sur la PAGE Clients !!!!!!!!!  ça plante             
      exit();
   }
   // FERMER le if du POST id (client à AJOUTER)---------------------------------------------------------------- POST   


    // récupérer un get vide qui n existe pas ---------------------------------------------- Déclenché par (e) le GET
    //          donc quand on GET (demande) le formulaire, quand je clique (e) sur bouton AJOUTER de la liste clients  
    if(empty($_GET["id"])){
      include_once("header.php"); // inclure le header dans toutes les PAGES: avec la navigation NAV -->
      $GLOBALS['information_message'] = "";
      $GLOBALS['connexion_message'] = "";    
      //
      // je fais un get id et je test empty VIDE car je n'ai pas de id en création, pas encore
      // c'est juste pour faire un $_GET  pour rendre mon GET étanche
      //
      // déterminer la liste des departements pour le select (liste déroulante)
      // connect, prepare + execute
      $le_SQL = "SELECT departement_code, departement_nom FROM departement";
      $connexion = new connect();
      $requete = $connexion->prepare($le_SQL);    
      $requete -> execute();
      $tabDepartements = $requete -> fetchAll();  // tableau associatif
?>

      <!-- Begin page content -->
      <main class="flex-shrink-0">
        <div class="container">
          <h1 class="mt-5">Ajouter un client</h1>

          <!-- FORMULAIRE DE SAISIE DU CLIENT-->
          <form class="row g-3" method="POST">
            <!-- nom/TELEPHONE cote-à-cote -->
            <!-- nom -->
            <div class="col-md-6">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" class="form-control" placeholder="saisir le nom" required
                    id="nom" name="nom"/>
            </div>
            <!-- telephone  -->
            <div class="col-md-6">
              <label for="telephone" class="form-label">Telephone</label>
              <input type="text" class="form-control" placeholder="saisir le telephone" required
                    id="telephone" name="telephone"/>
            </div>

            <!-- departement/VILLE  cote-à-cote en col-md-6 -->
            <!-- departement - liste déroulante                                       select  -->
            <div class="col-md-6">              
              <label for="selectdepartement" class="form-label">Département</label>
              <select class="form-control" required
                      name="selectdepartement" id="selectdepartement">
                <option value="">Sélectionner un département</option>
                <?php 
                // on boucle pour récupérer chaque element département un par un et
                //  CREER une option à chaque ligne
                foreach($tabDepartements as $tabvalues){
                  echo "<option value=" .$tabvalues["departement_code"]. ">".$tabvalues["departement_code"].' '.$tabvalues["departement_nom"]."</option>";
                }
                ?>                
              </select>
            </div>            
            <!-- ville - liste déroulante                                             select  -->
            <div class="col-md-6">                            
              <label for="selectville" class="form-label">Ville</label>
              <select class="form-control" required
                      name="selectville" id="selectville">
                <option value="">Sélectionner d'abord un département</option>              
              </select>
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
  // FERMER le if du GET id (client à CRER)--------------------------------------------------------------------- GET  
  $requete -> closeCursor();
  } 
?>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
