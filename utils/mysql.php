<?php

// Connection au serveur
try {
  $dns = 'mysql:host=localhost;dbname=bienchoisirsonechange';
  $utilisateur = 'root';
  $motDePasse = '';
 
  // Options de connection
  $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND    => "SET NAMES utf8"
  );
 
  // Initialisation de la connection
  $connection = new PDO( $dns, $utilisateur, $motDePasse, $options );
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch ( Exception $e ) {
  echo "Connection à MySQL impossible : ", $e->getMessage();
  die();
}

?>
