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

    // il faut récupérer tous les messages dans la table messages -> requête sql avec select 
    // $sql_messages = $pdo->query("SELECT date, pseudo, user_id, content FROM messages")->fetchALl();

    // il faut enregistrer les messages
    if (isset($_POST['add-message'])) {
        $data = [
            'id' => $_SESSION['LOGGED_USER_ID'],
            'content' => $_POST['add-message']
        ];
        $sql_register_messages = "INSERT INTO messages (user_id, content, date) VALUES (:id, :content, curdate())";
        $stmt = $pdo->prepare($sql_register_messages);
        $stmt->execute($data);
    }

    
    //pour supprimer les messages de la ligne voulu 

    if (isset($_POST['id_delete'])) {
        $sql_delete_messages = "DELETE FROM messages WHERE id=? ";
        $stmt = $pdo->prepare($sql_delete_messages);
        $stmt->execute([$_POST['id_delete']]);
    }

    //pour modifier les messages de la ligne voulu
    if (isset ($_POST['id_modify'])){
    
        $sql_modify_messages = "UPDATE messages SET content=? WHERE id=?";
        $stmt = $pdo->prepare($sql_modify_messages);
        $stmt->execute([$_POST['content'], $_POST['id_modify']]);
     }  

    //pour afficher les messages correspondant aux utilisateurs (jonction table users et messages)
    $sql_messages = $pdo->query("SELECT messages.id, pseudo, messages.content, date
    FROM users
    INNER JOIN messages
    ON users.id = messages.user_id")->fetchALl();


}

/*On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/ catch (PDOException $e) {
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
                                    <textarea name="add-message" id="" cols="27" rows="10">
                                  </textarea>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                        </form>
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

                        <!-- Modal pour modifier -->
                        <div class="modal fade" id="modif<?= $sql_message['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterContent" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered light" role="document">
                                <div class="modal-content">
                                    <div class="modal-header ">
                                        <h5 class="modal-title" id="exampleModalCenterContent">Votre message</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                                <div class="form-group">
                                                    <textarea name="content" id="<?= $sql_message['id']?>" cols="27" rows="10"><?= $sql_message['content'] ?></textarea>
                                                </div>
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>

                                        <td>
                                            <form action='' method="post">
                                                <input name="id_modify" value=<?= $sql_message['id']?> hidden></input>
                                                <button type="button" name="modify" class="btn btn-success mb-2" data-toggle="modal" data-target="#modif<?= $sql_message['id']?>"><i class="fa-solid fa-pen"></i>Modifier</button>
                                        </form>
                                        </td>
                                      </form>
                                </div>
                            </div>
                        </div>                  
                        <td>
                            <form action='' method="post">
                                <input name="id_delete" value=<?= $sql_message['id']?> hidden></input>
                                <button type="submit" name='delete' class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Supprimer</button>
                            </form>
                        </td>
                </tr>
                        
                 
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'elements/footer.php'; ?>