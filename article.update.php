<?php
  // -- PAGE article update ( MODIFIER ARTICLE )  --
  $article = true;      
   include_once("_connexion.php");
   // inclure le header dans toutes les PAGES; MAIS dans le GET: avec la navigation NAV -->
   // UPDATE ARTICLE : UPDATE ---------------------------------------------------------------------- Déclenché par (e) le POST
   //                           donc: quand on POST le formulaire, click (e) sur bouton submit [MODIFIER] en bas de formulaire
   if(!empty($_POST["idarticle"])&&
   !empty($_POST["libellearticle"])&&
   !empty($_POST["prix_unitaire"]) ){
    // on peut mettre à jour la BDD: article ------------------------------------------------------------------ (1)
    $le_SQL = "UPDATE article 
      SET libellearticle= :libellearticle, prix_unitaire= :prix_unitaire 
      WHERE idarticle= :idarticle";
    // connect, prepare + bindParam 
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);
    $requete -> bindParam(":libellearticle", $libellearticle);
    $requete -> bindParam(":prix_unitaire", $prix_unitaire);
    $requete -> bindParam(":idarticle", $idarticle);
    //
    // DONNEES + execute
    $libellearticle = $_POST["libellearticle"];
    $prix_unitaire = $_POST["prix_unitaire"];
    $idarticle = $_POST["idarticle"];
    $requete -> execute();  
    // echo "<br/>le var dump tabimagearticle dans S_FILES <br/>";
    // var_dump($_FILES);
    //
    // image si Nécessaire =================================================================================== (?)  
    // & uniquement si Nécessaire
    if(!empty($_FILES)){
        //
        // UPLOAD IMAGE : imagearticle ; si upload ok al Màj BDD
        if(!is_dir("images")){
          // CREER le dossier
          mkdir("images");
        }
        //
        // SUPPRESSION AVANT création ---------------------------------------------------------------------------------
        // ON Supprime toutes les images de l'article: pour les re-créer
        // CAR: on ne saurra jamais qui est qui !
        // sur le DOSSIER du SERVEUR------------------------------------         
        $le_SQL = "SELECT * FROM image WHERE idarticle= :idarticle";
        // connect, prepare + bindParam 
        $connexion4 = new connect();
        $requete4 = $connexion4->prepare($le_SQL);
        $requete4 -> bindParam(":idarticle", $idarticle);      
        //
        // DONNEES + execute
        $idarticle = $_POST["idarticle"];
        $requete4 -> execute();
        while($itemImage = $requete4 -> fetch()):
          unlink($itemImage["cheminimage"]); // suppression
        endwhile;
        $requete -> closeCursor();
        // dans la BASE DE DONNEES---------------------------------------
        $le_SQL = "DELETE FROM image
        WHERE idarticle= :idarticle";
        // connect, prepare + bindParam 
        $connexion3 = new connect();
        $requete3 = $connexion3->prepare($le_SQL);        
        $requete3 -> bindParam(":idarticle", $idarticle);    
        //
        // DONNEES + execute
        $idarticle = $_POST["idarticle"];
        $requete3 -> execute();          

        // BOUCLE sur le nombre de fichier ======================================================================= DO1
        $nombre_fichiers = count($_FILES["tabimagearticle"]["name"]);
        for($ii=0; $ii<$nombre_fichiers; $ii++){
          if(empty($_FILES["tabimagearticle"]["size"][$ii])||
          $_POST["MAX_FILE_SIZE"] < $_FILES["tabimagearticle"]["size"][$ii]){
           // KO: la taille Maxi est < à la taille de l'image
           //     image trop volumineuse alors: =>  on ne fait rien
          }else{
            // OK
            // DEPLACER le fichier image temporaire vers dossier serveur
            $extension=pathinfo($_FILES["tabimagearticle"]["name"][$ii], PATHINFO_EXTENSION);//extrait extension
            if(!in_array($extension, ["jpg", "jpeg", "png"])){
              echo "L'extension que vous avez choisi n'est pas autorisé";
            }else{
              $path_image = "images/".time().$_FILES["tabimagearticle"]["name"][$ii];
              $upload = move_uploaded_file($_FILES["tabimagearticle"]["tmp_name"][$ii],
                                            $path_image);
              if(!$upload){
                echo ($upload)?"transfert ok":"transfert ko, erreur = ".$_FILES["tabimagearticle"]["error"][$ii];          
              }else{
                // OK: image uploadé              
                // on peut mettre à jour la BDD: image ----------------------------------------------------------- (2)
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
                $nomimage = $_FILES["tabimagearticle"]["name"][$ii];
                $cheminimage = $path_image;
                $tailleimage = $_FILES["tabimagearticle"]["size"][$ii];
                $idarticle = $_POST["idarticle"];
                $requete2 -> execute();                                      
              }//FINSI:upload ok
            }//FINSI:jpeg ok
          }//FINSI:taille image ok          
        }//ENDFOR: tableau ====================================================================================== ENDO1     
    }//FINSI:image Nécessaire--------------
    //
    $msg = "l' article a été modifié avec succés.";
    $GLOBALS['information_message'] = $msg;      
    $article = false;
    header("Location: articles.php"); // REDIRECTION sur la PAGE Articles     
    exit();
   }
   // FERMER le if du POST id (article à MODIFIER)---------------------------------------------------------------------- POST


  // récupérer l'id du article à MODIFIER ---------------------------------------------------------- Déclenché par (e) le GET
  //                  donc quand on GET (demande) le formulaire, quand je clique (e) sur bouton MODIFIER de la liste articles
  if(!empty($_GET["id"])){    
    include_once("header.php"); // inclure le header dans toutes les PAGES: avec la navigation NAV -->
    $GLOBALS['information_message'] = "";
    $GLOBALS['connexion_message'] = "";
    // récupérer l'article ----------------------------------------------------------------------- (1)
    $le_SQL = "SELECT * FROM article WHERE idarticle= :idarticle";
    // connect, prepare + bindParam 
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);
    $requete -> bindParam(":idarticle", $idarticle);      
    //
    // DONNEES + execute
    $idarticle = $_GET["id"];      
    $requete -> execute();
    $tabArticle = $requete -> fetch();
    // echo "debug sur le tableau tabArticle  <br/>";
    // var_dump($tabArticle);
    // récupérer l'image ------------------------------------------------------------------------- (2)
    
    $le_SQL = "SELECT * FROM image WHERE idarticle= :idarticle";
    // connect, prepare + bindParam 
    $connexion2 = new connect();
    $requete2 = $connexion2->prepare($le_SQL);
    $requete2 -> bindParam(":idarticle", $idarticle);      
    //
    // DONNEES + execute
    $idarticle = $_GET["id"];      
    $requete2 -> execute();
    //$tabImage = $requete2 -> fetch();  // pour un
    //$tabImage = $requete2 -> fetchAll(); // pour plusieurs
    // echo "debug sur le tableau tabImage  <br/>";
    // var_dump($tabImage);
?>
    <!-- Begin page content                                            dans le if GET -->
    <main class="flex-shrink-0">
      <div class="container">
        <h1 class="mt-5">Modifier un article</h1>

        <!-- FORMULAIRE DE SAISIE DU ARTICLE -->
        <form class="row g-3" method="POST" enctype="multipart/form-data">
          <!-- id caché : on en aura besoin -->
          <input type="hidden"
                 id="idarticle" name="idarticle" Value="<?php echo $tabArticle["idarticle"]?>"/>
                 <form class="row g-3" method="POST" enctype="multipart/form-data">
          <!-- variable caché, taille maxi du fichier image 1 millions d'octets : MAX_FILE_SIZE -->
          <input type="hidden"
                id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" Value="1000000"/>  


          <!-- libelle article -->
          <div class="col-md-12">
            <label for="libellearticle">Libellé article</label>               
            <textarea class="form-control" required 
                      id="libellearticle" name="libellearticle"><?php echo $tabArticle["libellearticle"]?>
            </textarea>               
          </div>
          <!-- prix unitaire -->
          <div class="col-md-4">
            <label for="prix_unitaire" class="form-label">Prix unitaire</label>
            <input type="text" class="form-control" required
                  id="prix_unitaire" name="prix_unitaire" Value="<?php echo $tabArticle["prix_unitaire"]?>"/>
          </div>
          <!-- image en BDD : nomimage cheminimage -->
          <div class="col-md-8">
            <label for="imagearticle" class="form-label">vos images</label>
            <!-- BOUCLE sur les images ================DO1:  -->
            <?php while($itemImage = $requete2 -> fetch()):?>
              <!-- X supprimer une image avec lien sur delete -->
               <a class="btn btn-outline-danger" style="position: absolute"
                  href="delete.php?idarticle=<?php echo $itemImage["idarticle"]?>&idimage=<?php echo $itemImage["idimage"] ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                  </svg>                
               </a>
              <img width="100" height="100"
              src="<?php echo $itemImage["cheminimage"] ?>" alt="<?php echo $itemImage["nomimage"] ?>"/>
            <?php endwhile; ?>
            <!-- FIN BOUCLE sur les images =========ENDDO1  -->
          </div>
          <!-- image NEW -->
          <div class="col-md-12">
            <label for="imagearticle" class="form-label">Charger vos images</label>
            <input type="file" class="form-control"
                  id="imagearticle" name="tabimagearticle[]" multiple/>
            <p>PNG, JPEG, JPG</p>
          </div>               


          <!-- BOUTON submit: MODIFIER -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary">MODIFIER</button>
          </div>
          <div class="col-6">
            <a href="articles.php">
              <button type="button" class="btn btn-primary">RETOUR ARTICLES</button>
            </a>
          </div>      
        </form> 
        <!-- -->

      </div>
    </main>

<?php
  // FERMER le if du GET id (article à MODIFIER)-------------------------------------- GET
  $requete -> closeCursor();
  $requete2 -> closeCursor();
  } 
?>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
