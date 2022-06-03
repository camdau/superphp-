<?php

$host = 'db'; //Nom donné dans le docker-compose.yml
$user = 'myuser';
$password = 'monpassword';
$db = 'tutoseu';

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql_pseudo = $pdo->query("SELECT pseudo FROM users")->fetchALl();



echo json_encode($sql_pseudo);
  
//var_dump($sql_pseudo);

?>  