<?php   
   include_once("_connexion.php");
   // inclure le header dans toutes les PAGES: avec la navigation NAV -->
   // -- PAGE addarticle ( SAISIE ARTICLE )  --
   $article = true;
   // ADD ARTICLE : INSERT --------------------------------------------------- Déclenché par (e) le $_FILES & $_POST
   //                  donc: quand on POST le formulaire, click (e) sur bouton submit [AJOUTER] en bas de formulaire  
   if(!empty($_POST["libellearticle"])&&
      !empty($_POST["prix_unitaire"])&&
      !empty($_FILES["imagearticle"]["size"])&&
      $_POST["MAX_FILE_SIZE"] >= $_FILES["imagearticle"]["size"] ){
      //
      // UPLOAD IMAGE : imagearticle ; si upload ok al Màj BDD
      if(!is_dir("images")){
        // CREER le dossier
        mkdir("images");
      }
      // DEPLACER le fichier image temporaire vers dossier serveur
      $extension=pathinfo($_FILES["imagearticle"]["name"], PATHINFO_EXTENSION);//extrait extension
      if(!in_array($extension, ["jpg", "jpeg", "png"])){
        echo "L'extension que vous avez choisi n'est pas autorisé";
      }else{
        $path_image = "images/".time().$_FILES["imagearticle"]["name"];
        $upload = move_uploaded_file($_FILES["imagearticle"]["tmp_name"],
                                     $path_image);
        if(!$upload){
          echo ($upload)?"transfert ok":"transfert ko, erreur = ".$_FILES["imagearticle"]["error"];          
        }else{
          // OK: image uploadé
          // on peut mettre à jour la BDD: article -------------------------------------------- (1)
          $le_SQL = "INSERT INTO article
          (libellearticle, prix_unitaire) 
          VALUES 
          (:libellearticle, :prix_unitaire)";    
          // connect, prepare + bindParam 
          $connexion = new connect();
          $requete = $connexion->prepare($le_SQL);
          $requete -> bindParam(":libellearticle", $libellearticle);
          $requete -> bindParam(":prix_unitaire", $prix_unitaire);      
          //
          // DONNEES + execute
          $libellearticle = $_POST["libellearticle"];
          $prix_unitaire = $_POST["prix_unitaire"];
          $requete -> execute();                   
          $dernier_idarticle = $connexion -> lastInsertId();   // DERNIER idarticle inséré
          $requete -> closeCursor(); 
          // on peut mettre à jour la BDD: image ---------------------------------------------- (2)          
          $le_SQL = "INSERT INTO image
          (nomimage, cheminimage, tailleimage, idarticle) 
          VALUES 
          (:nomimage, :cheminimage, :tailleimage, :idarticle)";    
          // connect, prepare + bindParam 
          $connexion2 = new connect();
          $requete2 = $connexion2->prepare($le_SQL);
          $requete2 -> bindParam(":nomimage", $nomimage);
          $requete2 -> bindParam(":cheminimage", $cheminimage);  
          $requete2 -> bindParam(":tailleimage", $tailleimage);
          $requete2 -> bindParam(":idarticle", $idarticle);                
          //
          // DONNEES + execute
          $nomimage = $_FILES["imagearticle"]["name"];
          $cheminimage = $path_image;
          $tailleimage = $_FILES["imagearticle"]["size"];
          $idarticle = $dernier_idarticle;
          $requete2 -> execute();          
          $dernier_id = $connexion -> lastInsertId();   // DERNIER idarticle inséré
          $requete2 -> closeCursor();

          $msg = "l'article a été ajouté avec succés.";
          $GLOBALS['information_message'] = $msg;      
          $article = false;
          header("Location: articles.php"); // REDIRECTION sur la PAGE Clients !!!!!!!!!  ça plante             
          exit();    
        }//FINSI:upload ok   
      }//FINSI:jpeg ok
   }
   // FERMER le if du POST id (article à AJOUTER)---------------------------------------------------------------- POST   


    // récupérer un get vide qui n existe pas ----------------------------------------------- Déclenché par (e) le GET
    //          donc quand on GET (demande) le formulaire, quand je clique (e) sur bouton AJOUTER de la liste articles  
    if(empty($_GET["id"])){
      include_once("header.php"); // inclure le header dans toutes les PAGES: avec la navigation NAV -->
      $GLOBALS['information_message'] = "";
      $GLOBALS['connexion_message'] = "";    
      //
      // je fais un get id et je test empty VIDE car je n'ai pas de id en création, pas encore
      // c'est juste pour faire un $_GET  pour rendre mon GET étanche   
?>

      <!-- Begin page content -->
      <main class="flex-shrink-0">
        <div class="container">
          <h1 class="mt-5">Ajouter un article</h1>

          <!-- FORMULAIRE DE SAISIE DE L ARTICLE-->
          <form class="row g-3" method="POST" enctype="multipart/form-data">
            <!-- variable caché, taille maxi du fichier image 1 millions d'octets : MAX_FILE_SIZE -->
            <input type="hidden"
                  id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" Value="1000000"/>            

            <!-- libelle article -->
            <div class="col-md-12">
              <label for="libellearticle">Libellé article</label>               
              <textarea class="form-control" placeholder="Mettre le libellé article" required 
                        id="libellearticle" name="libellearticle"></textarea>               
            </div>
            <!-- prix unitaire -->
            <div class="col-md-12">
              <label for="prix_unitaire" class="form-label">Prix unitaire</label>
              <input type="text" class="form-control" placeholder="Mettre le Prix unitaire" required
                    id="prix_unitaire" name="prix_unitaire"/>
            </div>      
            <!-- image -->
            <div class="col-md-12">
              <label for="imagearticle" class="form-label">Charger vos images</label>
              <input type="file" class="form-control" required
                    id="imagearticle" name="imagearticle"/>
              <p>PNG, JPEG, JPG</p>
            </div>               

            <!-- BOUTON submit: AJOUTER -->
            <div class="col-6">
              <button type="submit" class="btn btn-primary">AJOUTER</button>
            </div>
            <div class="col-6">
              <a href="articles.php">
                <button type="button" class="btn btn-primary">RETOUR ARTICLE</button>
              </a>
            </div>      
          </form> 
          <!-- -->

        </div>
      </main>
<?php  
    // FERMER le if du GET id (article à CREER)------------------------------------------------------------------- GET  
    } 
?>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
