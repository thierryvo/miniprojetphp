<?php
include_once("_connexion.php");
if(!empty($_POST["departement_code"])){
    //
    // CREER la requet SQL pour récupérer les villes du Département Choisi:
    // déterminer la liste des viles pour le select (liste déroulante)
    // connect, prepare + execute
    $le_SQL = "SELECT ville_id, ville_code_postal, ville_nom FROM villes_france WHERE ville_departement= :ville_departement
               ORDER BY ville_code_postal";
    $connexion = new connect();
    $requete = $connexion->prepare($le_SQL);    
    $requete -> bindParam(":ville_departement", $ville_departement);
    //
    // DONNEES + execute
    $ville_departement = $_POST["departement_code"];
    $requete -> execute();
    //
    // Parcourir les données: la réponse renvoyé sera: la liste des options
    echo "<option value=''>"."Vous pouvez maintenant sélectionner une ville correspondant au département"."</option>";
    while($itemVille = $requete -> fetch()):        
        echo "<option value=" .$itemVille["ville_id"]. ">".$itemVille["ville_id"].'- '.$itemVille["ville_code_postal"].' '.$itemVille["ville_nom"]."</option>";
    endwhile;
    $requete -> closeCursor();
}
