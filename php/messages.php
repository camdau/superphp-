<?php
//  session_start();
//  $_SESSION['LOGGED_USER'] = $sql_user['pseudo'];
session_start();
//  die(var_dump($_SESSION));
echo $_SESSION['LOGGED_USER'];

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

    // il faut récupérer tous les messages dans la table messages -> requête sql avec select 
    $sql_messages = $pdo->query("SELECT date, pseudo, user_id, content FROM messages")->fetchALl();

    // il faut enregistrer les messages 
    // $sql_messages = $pdo->query();

    // var_dump($sql_messages);
}

/*On capture les exceptions si une exception est lancée et on afficheles informations relatives à celle-ci*/ catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<div class="container">
    <div class="row">
        <div>
            <h1 class="text-center mt-3">Messagerie</h1>
        </div>
        <!-- Button trigger modal -->
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="fa-solid fa-circle-plus"></i> &ensp;
                Ajouter
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered light" role="document">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Votre message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          <form action="" method="post"> 
                              <div class="form-group">
                                  <textarea name="add-message" id="" cols="44" rows="10"></textarea>
                              </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

<?php require 'elements/footer.php'; ?>