<!-- PAGE addclient ( SAISIE CLIENT )  -->
<?php
  $client = true;
   // inclure le header dans toutes les PAGES: avec la navigation NAV -->
   include_once("header.php");   
?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Ajouter un client</h1>

    <!-- FORMULAIRE DE SAISIE DU CLIENT-->
    <form class="row g-3">
      <!-- nom/ville cote-à-cote -->
      <div class="col-md-6">
        <label for="nom" class="form-label">Nom</label>
        <input type="email" class="form-control" id="nom" placeholder="Nom">
      </div>
      <div class="col-md-6">
        <label for="ville" class="form-label">Ville</label>
        <input type="password" class="form-control" id="ville" placeholder="Ville">
      </div>
      <!-- telephone seul -->
      <div class="col-12">
        <label for="telephone" class="form-label">Telephone</label>
        <input type="text" class="form-control" id="telephone" placeholder="Telephone">
      </div>

      <!-- adresse  seul -->
      <div class="col-12">
        <label for="inputAddress2" class="form-label">Address 2</label>
        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
      </div>
      
      <!-- city (6/12)     state (4/12)  zip (2/12) -->
      <!-- city (6/12)  -->
      <div class="col-md-6">
        <label for="inputCity" class="form-label">City</label>
        <input type="text" class="form-control" id="inputCity">
      </div>
      <!-- state (4/12)  Select liste déroulante avec option   -->
      <div class="col-md-4">
        <label for="inputState" class="form-label">State</label>
        <select id="inputState" class="form-select">
          <option selected>Choose...</option>
          <option>...</option>
        </select>
      </div>
      <!-- zip (2/12) -->
      <div class="col-md-2">
        <label for="inputZip" class="form-label">Zip</label>
        <input type="text" class="form-control" id="inputZip">
      </div>

      <!-- check (seul)  case à cocher -->
      <div class="col-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck">
          <label class="form-check-label" for="gridCheck">
            Check me out
          </label>
        </div>
      </div>
      <!-- BOUTON submit: Sign in -->
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Sign in</button>
      </div>
    </form> 
    <!-- -->

  </div>
</main>

<?php
   // inclure le footer avec fin body fin  html dedans  -->
   include_once("footer.php");
?>
