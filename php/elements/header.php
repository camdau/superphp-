<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Mon site' ?></title>
  <!-- BOOTSWATCH -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- FONT AWESOME -->
  <script src="https://kit.fontawesome.com/74635a3956.js" crossorigin="anonymous"></script>
  <!-- JS -->
  <script src="../js/modal.js"></script>
  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">
  <!-- STYLE PERSO -->
  <link rel="stylesheet" href="css/style.css">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Super PHP </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <?php echo "<a class=\"nav-link\" href=\"index.php\">Accueil</a>"; ?>
          </li>
          <li class="nav-item">
            <?php echo "<a class=\"nav-link\" href=\"about.php\">Qui sommes-nous?</a>"; ?>
          </li>
          <li class="nav-item">
            <?php echo "<a class=\"nav-link\" href=\"articles.php\">Nouveautés php</a>"; ?>
          </li>
          <li class="nav-item">
            <?php echo "<a class=\"nav-link\" href=\"messages.php\">Messagerie</a>"; ?>
          </li>
        </ul>

        <form class="d-flex">
         
          <div class="mt-1 mr-5">
          <i class="fa-solid fa-2x fa-user"></i>
          <span class="pseudo-user">
         
          <?php
          echo $_SESSION['LOGGED_USER'];

          ?></span>
          </div>

          <?php if (isset ($_SESSION['LOGGED_USER'])){ 
         
          ?>
          <button type="submit" class="btn btn-secondary  my-2 my-sm-0"><a href="login.php">Déconnexion</a></button> 
         
          <?php
          } else {?>
          <button type="submit" class="btn btn-secondary  my-2 my-sm-0"><a href="login.php">Connexion</a></button>
          <?php
          }
         ?>
           
      </form>
      </div>
    </div>
  </nav>


</head>

<body>