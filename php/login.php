<?php
ob_start();

echo $_SESSION['LOGGED_USER'] = $sql_user['pseudo'];

$title = "Sign in";
require_once 'class/Message.php';
require_once 'class/GuestBook.php';
require 'elements/header.php';

$errors = null;
$success = false;

$host = 'db'; //Nom donné dans le docker-compose.yml
$user = 'myuser';
$password = 'monpassword';
$db = 'tutoseu';


try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    //On définit le mode d'erreur de PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['mail']) && isset($_POST['password'])) {

        // il faut récupérer les mails et mots de passe dans la table users -> requête sql avec select 
        $sql_users = $pdo->query("SELECT mail, password, pseudo  FROM users")->fetchALl();

        // il faut parcourir tous les mails et mots de passe avec une boucle

        $password = $_POST['password'];
        $mail = $_POST['mail'];


        foreach ($sql_users as $sql_user) {


            // comparer toutes les adresses mail users et mots de passe dans bdd avec celle donné par l'utilisateur (condition == alors message d'erreur)
            if ($sql_user['mail'] == $_POST['mail'] && password_verify($_POST['password'], $sql_user['password'])) {
                session_start();
                $_SESSION['LOGGED_USER'] = $sql_user['pseudo'];
                header("Location: http://localhost/messages.php");
                exit();
            }
        }

        ?> <div class="alert alert-dismissible alert-warning">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Mot de passe invalide!</strong> <a href="#" class="alert-link"></a>
            </div>
        <?php

    }
}

/*On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/ catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<div class="container">
    <h1 class="text-center mt-3">Se connecter</h1>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            Formulaire invalide
        </div>
    <?php endif ?>

    <?php if ($success) : ?>
        <div class="alert alert-success">
            Merci pour votre message
        </div>
    <?php endif ?>

    <form action="" method="post">
        <div class=" row d-flex flex-column align-items-center">

            <div class="form-group col-md-6">
                <input type="email" name="mail" placeholder="Votre email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['mail'])) : ?>
                    <div class="invalid-feedback"><?= $errors['mail'] ?></div>
                <?php endif ?>
            </div>
            <div class="form-group col-md-6">
                <input type="password" name="password" placeholder="Votre mot de passe" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['password'])) : ?>
                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                <?php endif ?>
                <p><a href="createaccount.php">Pas encore de compte? Créez en un!</a></p>
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">Se connecter</button>

            </div>


        </div>
    </form>

    <?php require 'elements/footer.php'; ?>