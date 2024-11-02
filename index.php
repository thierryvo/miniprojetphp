<?php
    // -- PAGE accueil de l’application  --
    $index = true;
    // inclure le header dans toutes les PAGES: avec la navigation NAV -->
    include_once("header.php");
    include_once("_connexion.php");
    $nom_fonction = "";
    $connexion_message = "";
    $information_message = "";
    $erreur_message = "";    
?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Accueil</h1>

    <!-- Instancier un Objet de connexion -->
    <?php $pdo = new connect();?>     
    
    <!-- Intégrer la datatable jQuery -->
    <table id="datatable" class="display">
      <thead>
          <tr>
              <th>Column 1</th>
              <th>Column 2</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td>Row 1 Data 1</td>
              <td>Row 1 Data 2</td>
          </tr>                                                                                                 
      </tbody>
    </table>
    <!-- -->

  </div>
</main>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
?>
