<?php
    // -- PAGE accueil de l’application  --
    $index = true;
    // inclure le header dans toutes les PAGES: avec la navigation NAV -->
    include_once("header.php");
    include_once("_connexion.php");
    $idligne=0;
    $nom_fonction = "";
    $connexion_message = "";
    $information_message = "";
    $erreur_message = "";    
?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Commandes</h1>
    
    <!-- Instancier un Objet de connexion + récupérer les données-->
    <?php $connexion = new connect();
    // prepare + execute + fetchall
    $le_SQL = "SELECT a.idcommande,
       c.nom,
       c.telephone,
       c.ville,
       a.datecommande,
       d.libellearticle,
       b.quantite
     FROM commande as a, ligne_commande as b, client as c, article as d
     WHERE a.idcommande = b.idcommande
       AND a.idclient = c.idclient
       AND b.idarticle = d.idarticle";    
    $requete = $connexion->prepare($le_SQL);
    $requete -> execute();      
    // $tabCommandes =  $requete -> fetchAll();    
    // echo "<br/> un var_dump de tabCommandes:  <br/>";
    // var_dump($tabCommandes);
    ?>     
    
    <!-- Intégrer la datatable jQuery -->
    <table id="datatable" class="display">
      <thead>
          <tr>
              <th></th>
              <th>NOM</th>
              <th>TELEPHONE</th>
              <th>VILLE</th>
              <th>DATE COMMANDE</th>
              <th>LIBELLE ARTICLE</th>
              <th>Quantité</th>                          
          </tr>
      </thead>
      <tbody>
          <!-- BOUCLE fetch PHP sur le tableau des commandes -->
          <?php while($itemCommande =  $requete -> fetch()):
                $idligne++;
          ?>        
          <tr>
              <td>
                <a href="commande.detail.php?id=<?php echo $itemCommande["idcommande"]?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                  </svg>
                </a>
              </td>    
              <td><?php echo $itemCommande["nom"]; ?></td>
              <td><?php echo $itemCommande["telephone"]; ?></td>              
              <td><?php echo $itemCommande["ville"]; ?></td>
              <td><?php echo $itemCommande["datecommande"]; ?></td>       
              <td><?php echo $itemCommande["libellearticle"]; ?></td> 
              <td><?php echo $itemCommande["quantite"]; ?></td>                     
          </tr>
        
          <?php endwhile; ?>  
          <!-- FIN BOUCLE fetch PHP sur commandes -->             
      </tbody>
    </table>
    <!-- -->

  </div>
</main>

<?php
   // GERMER le curseur SQL fetch  & inclure le footer avec fin body fin  html dedans  -->
   $requete -> closeCursor();
   include_once("footer.php");
