<?php
$title = "Messagerie";
require 'elements/header.php';


$host = 'db'; //Nom donné dans le docker-compose.yml
$user = 'myuser';
$password = 'monpassword';
$db = 'tutoseu';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    //On définit le mode d'erreur de PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // il faut récupérer tous les massages dans la table messages -> requête sql avec select 
    $sql_messages = $pdo->query("SELECT date, pseudo, user_id, content FROM messages")->fetchALl();

}

/*On capture les exceptions si une exception est lancée et on afficheles informations relatives à celle-ci*/ 
catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<div class="container">
    <div class="row">
        <h1 class="text-center mt-3">Messagerie</h1>
        <p class="text-right"><button type="button" class="btn btn-secondary"><i class="fa-solid fa-circle-plus"></i> &ensp; Ajouter</button></p>
    </div>
</div>

<div class="container">
    <div class="row d-flex flex-column align-items-center">
        <table class="table table-hover col-md-6">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Messages</th>
                    <th scope="col">Edition</th>
                </tr>
            </thead>
            <tbody>
                <tr> 
                    <?php foreach ($sql_messages as $sql_message) { ?>

                    <th scope="row"><?= $sql_message['date'] ?></th>
                    <td><?= $sql_message['pseudo'] ?></td>
                    <td><?= $sql_message['content'] ?></td>
                    <td> 
                        <button type="button" class="btn btn-success"><i class="fa-solid fa-pen"></i> &ensp; Mis à jour</button>
                            &ensp;
                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> &ensp; Supprimer</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>