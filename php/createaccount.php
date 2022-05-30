<?php

require_once 'class/Message.php';
require_once 'class/GuestBook.php';
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
    
    if (isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['password'])) {

        // il faut récupérer les mails et pseudos dans la table users -> requête sql avec select 
        $sql_users = $pdo->query("SELECT mail, pseudo FROM users")->fetchALl();

        // il faut parcourir tous les mails et pseudos avec une boucle
        $pseudo = $_POST['pseudo'];
        $mail = $_POST['mail'];
        foreach ($sql_users as $sql_user) {
            
            // comparer toutes les adresses users dans bdd avec celle donné par l'utilisateur (condition == alors message d'erreur)
            if ($sql_user['mail'] == $_POST['mail'] && $sql_user['pseudo'] == $_POST['pseudo'] ) {                
                $mail = null;
                $pseudo=null;
                break;
            } else {
                $pseudo = $_POST['pseudo'];
                $mail = $_POST['mail'];
            };
        }

 
        $data = [
            'name' => $_POST['name'],
            'firstname' => $_POST['firstname'],
            'pseudo' => $pseudo,
            'mail' => $mail,
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];


        $sql = "INSERT INTO users  (name, firstname, pseudo, mail, password) VALUES (:name, :firstname, :pseudo, :mail, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);


    }
}

/*On capture les exceptions si une exception est lancée et on afficheles informations relatives à celle-ci*/
 catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$title = "Création compte";
require 'elements/header.php';
?>

<div class="container">
    <h1 class="text-center mt-3">Créer un compte</h1>

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
                <input type="text" name="name" placeholder="Votre nom de famille" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['name'])) : ?>
                    <div class="invalid-feedback"><?= $errors['name'] ?></div>
                <?php endif ?>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="firstname" placeholder="Votre prénom" class="form-control <?= isset($errors['firstname']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['firstname'])) : ?>
                    <div class="invalid-feedback"><?= $errors['firstname'] ?></div>
                <?php endif ?>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="pseudo" placeholder="Votre pseudo" class="form-control <?= isset($errors['pseudo']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['pseudo'])) : ?>
                    <div class="invalid-feedback"><?= $errors['pseudo'] ?></div>
                <?php endif ?>
            </div>
            <div class="form-group col-md-6">
                <input type="email" name="mail" placeholder="Votre email" class="form-control <?= isset($errors['mail']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['mail'])) : ?>
                    <div class="invalid-feedback"><?= $errors['mail'] ?></div>
                <?php endif ?>
            </div>
            <div class="form-group col-md-6">
                <input type="password" name="password" placeholder="Votre mot de passe" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['password'])) : ?>
                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                <?php endif ?>
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">Se connecter</button>
            </div>


        </div>
    </form>



    <?php require 'elements/footer.php'; ?>