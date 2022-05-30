
<?php

$_SESSION['LOGGED_USER'] = $sql_user['pseudo'];

$title ="Accueil";
require 'elements/header.php';
?>

<h1 class="text-center mt-3">Accueil</h1>

<?php require 'elements/footer.php';?>
 