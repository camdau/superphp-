<?php

require_once 'class/Message.php';
require_once 'class/GuestBook.php';
$errors = null;
$success = false;

$host = 'db'; //Nom donné dans le docker-compose.yml
$user = 'myuser';
$password = 'monpassword';
$db = 'tutoseu';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    //On définit le mode d'erreur de PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['name'] ) && isset($_POST ['firstname']) && isset($_POST['pseudo'])){
    
        $data = [
        'name' => $_POST['name'],
        'firstname' => $_POST['firstname'],
        'pseudo' => $_POST['pseudo'],
        'age' => $_POST['age']
     ];
   
$sql = "INSERT INTO users  (name, firstname, pseudo, age) VALUES (:name, :firstname, :pseudo, :age)";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);
 };

}

    /*On capture les exceptions si une exception est lancée et on affiche
    *les informations relatives à celle-ci*/
    catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}


$title ="Blog";
require 'elements/header.php';
?>

<div class="container">
    <h1>Blog</h1>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        Formulaire invalide
    </div>
    <?php endif ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            Merci pour votre message
        </div>
    <?php endif ?>

    <form action="" method="post">
        <div class="form-group">
            <input  type="text" name="name" placeholder="Votre nom de famille" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['name'])): ?>      
            <div class="invalid-feedback"><?= $errors['name'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <input  type="text" name="firstname" placeholder="Votre prénom" class="form-control <?= isset($errors['firstname']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['firstname'])): ?>
            <div class="invalid-feedback"><?= $errors['firstname'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <input  type="text" name="pseudo" placeholder="Votre pseudo" class="form-control <?= isset($errors['pseudo']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['pseudo'])): ?>
            <div class="invalid-feedback"><?= $errors['pseudo'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <input  type="number" name="age" placeholder="Votre âge" class="form-control <?= isset($errors['age']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['age'])): ?>
            <div class="invalid-feedback"><?= $errors['age'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Votre message" class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? '')?></textarea>
            <?php if (isset($errors['message'])): ?>
            <div class="invalid-feedback"><?= $errors['message'] ?></div>
            <?php endif ?>
        </div>
        <button class="btn btn-primary">Envoyer</button>
    </form>

    <?php if (!empty($messages)): ?>
    <h1 class="mt-4">Vos messages</h1>

    <?php foreach($messages as $message): ?>
        <!-- <?= $message->toHTML(); ?> -->
    <?php endforeach ?>
    <?php endif ?>
</div>

<?php require 'elements/footer.php';?>
 