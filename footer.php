<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted">CopyRight 2024(Thierry VOZELLE)(cours de Lamyae) - Place sticky footer content here.   (Placez le contenu du pied de page collant ici.)</span>
    <div class="col-md-6">
      <p>      
        <?php
          if(!empty($GLOBALS['connexion_message'])){
            $msg = $GLOBALS['connexion_message'];
            echo "connexion: " .$msg;
          }
        ?>
      </p>
    </div>
    <div class="col-md-6">
      <p>
        <?php
          if(!empty($GLOBALS['information_message'])){
            $msg = $GLOBALS['information_message'];
            echo "info: " .$msg;
          }
        ?>
      </p>
    </div>
  </div>
</footer>

<!-- Initialiser la datable dans le footer car: il est préférable de charger le js après la PAGE-->
<script type="text/javascript" >  
  $(document).ready( function () {
    $('#datatable').DataTable({      
      "oLanguage": {
        "sLengthMenu": "Afficher MENU Enregistrements",
        "sSearch": "Rechercher:",
        "sInfo":"Total de TOTAL enregistrements (_END_ / _TOTAL_)",
        "oPaginate": {
          "sNext": "Suivant",
          "sPrevious":"Précédent"
        }
      }
    });
  });
</script>

<script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

      
  </body>
</html>
