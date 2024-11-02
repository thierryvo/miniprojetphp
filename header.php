<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <!-- header à inclure dans toutes les PAGES: avec la navigation NAV -->
    <title>Gestion des commandes</title>
    <link rel="canonical" href="css/sticky-footer-navbar.css">
    <!--  link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sticky-footer-navbar/"   lien NON trouvé   -->
    <!-- Bootstrap core CSS -->
<link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Favicons -->
<link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/favicon.ico">
<meta name="theme-color" content="#7952b3">
<!-- Ajouter les liens css & js de la datatable jQuery -->
<link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

<!-- -->
<style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
</style>

    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
    <!-- link href="sticky-footer-navbar.css" rel="stylesheet" -->
  </head>
  <body class="d-flex flex-column h-100">
    
<header>
  <!-- Fixed navbar : la GRANDE NAVBAR Noir en haut de la page -------------------------------------------------------------------------- -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Application commande</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <!-- liste avec les 3 liens du MENU -->
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <!-- 4 liens -->
          <li class="nav-item">
            <a class="nav-link <?php echo !empty($index) ? "active" : ''?>"  href="index.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo !empty($article) ? "active" : ''?>" href="articles.php">Articles</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo !empty($client) ? "active" : ''?>" href="clients.php">Clients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo !empty($commande) ? "active" : ''?>" href="commandes.php">Commandes</a>
          </li>          
          <!-- 1 liens désactivé -->
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
</header>
