<?php

/* Controller for simpler project 1
/* Connecting to the database */
require_once("db_config.php"); 

try {
  $host = $config['DB_HOST'];
  $dbname = $config['DB_DATABASE'];

  $conn = new PDO("mysql:host=$host;dbname=$dbname", $config['DB_USERNAME'], $config['DB_PASSWORD']);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


?>