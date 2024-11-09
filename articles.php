<?php
  // -- PAGE articles ( liste ) --
  $article = true;
  // inclure le header dans toutes les PAGES: avec la navigation NAV -->
  include_once("header.php");
  include_once("_connexion.php");
  $idligne=0;
  //
  // déterminer les articles déjà présent dans un ligne_commande
  // connect, prepare + execute
  $le_SQL = "SELECT idarticle FROM article WHERE idarticle IN (SELECT idarticle FROM ligne_commande)";
  $connexion = new connect();
  $requete = $connexion->prepare($le_SQL);    
  $requete -> execute();
  $tabArticleDansLignecommande = $requete -> fetchAll();
  $tabListeArticleDansLignecommande=[];
  // on boucle pour récupérer chaque element un par un
  foreach($tabArticleDansLignecommande as $tabvalues){
    foreach($tabvalues as $itemValeur){      
      $tabListeArticleDansLignecommande[] = $itemValeur;
    }
  }
?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Articles</h1>

    <!-- lien Add  AJOUTER un Article -->
    <a href="addarticle.php" class="btn btn-primary" style="float:right;margin-bottom:20px;">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
         <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
      </svg>
    </a>

    <!-- Instancier un Objet de connexion + récupérer les données-->
    <?php $connexion = new connect();
    // prepare + execute + fetchall
    $le_SQL = "SELECT * FROM article";    
    $requete = $connexion->prepare($le_SQL);
    $requete -> execute();      
    // $tabArticles =  $requete -> fetchAll();    
    // echo "<br/> un var_dump de tabArticles:  <br/>";
    // var_dump($tabArticles);
    ?> 

    <!-- Intégrer la datatable jQuery -->
    <table id="datatable" class="display">
      <thead>
          <tr>
              <th>ID</th>
              <th>LIBELLE ARTICLE</th>
              <th>PRIX UNITAIRE</th>              
              <th>ACTION</th>              
          </tr>
      </thead>
      <tbody>
          <!-- BOUCLE fetch PHP sur le tableau des Articles -->
          <?php while($itemArticle =  $requete -> fetch()):
                $idligne++;
          ?>
          <tr>
              <td><?php echo $itemArticle["idarticle"]; ?></td>
              <td><?php echo $itemArticle["libellearticle"]; ?></td>
              <td><?php echo $itemArticle["prix_unitaire"]; ?></td>
              <td>
                <!-- ACTION Update   redirection vers modifier -->
                <a href="article.update.php?id=<?php echo $itemArticle["idarticle"]?>" class="btn btn-success">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                  </svg>
                </a>
                <!-- ACTION Delete   BOUTON supprimer -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                        data-bs-target="#articleSupressionModal<?php echo $idligne?>"
                        <?php if(in_array($itemArticle["idarticle"], $tabListeArticleDansLignecommande)){ echo 'disabled'; } ?>>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                  </svg>
                </button>                
              </td>
          </tr>

          <!-- FENETRE MODAL dans la boucle while, après le tr, pour quelle soit pour toutes les lignes -->
          <!-- Modal -->
          <div class="modal fade" id="articleSupressionModal<?php echo $idligne?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">SUPRESSION ARTICLE</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Veuillez confirmer la suppression de l'article: <?php echo $itemArticle["idarticle"] ." - ". $itemArticle["libellearticle"]; ?>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ANNULER</button>
                  <!-- lien vers Article suppression -->
                  <a href="delete.php?idarticle=<?php echo $itemArticle["idarticle"]?>" class="btn btn-danger">CONFIRMER</a>
                </div>
              </div>
            </div>
          </div>
          <!-- -->

          <?php endwhile; ?>  
          <!-- FIN BOUCLE fetch PHP sur articles -->                                                  
      </tbody>
    </table>
    <!-- -->
    
  </div>
</main>

<?php
   // FERMER le curseur SQL fetch & inclure le footer avec fin body fin  html dedans  -->
   $requete -> closeCursor();
   include_once("footer.php");
