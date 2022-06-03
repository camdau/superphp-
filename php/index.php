<?php
session_start();

$title ="Accueil";
require 'elements/header.php';
?>

<h1 class="text-center mt-3">Accueil</h1>

<h2 class="ml-2">Bienvenue <?php echo $_SESSION['LOGGED_USER']; ?> sur le blog !</h2>


<div id="pseudo" class="form-group col-md-4">
  <label for="sel1">Selectionner des utilisateurs:</label>
  <select class="form-control" onchange="getdata();">
    <option></option>
    <option></option>

  </select>
</div>


<script>


function loadData() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        console.log(this.status);
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("pseudo").innerHTML =
            this.responseText; 
           // console.log(this.responseText );
       }
    };
    
    xhr.open('GET', 'http://localhost/getpseudo.php', true);
    xhr.send();
   
}


function getdata()
{
   var pseudo = document.getElementById("pseudo");

   if(pseudo)
   { 
    $.ajax({
      type: 'post',
      url: 'getpseudo.php',
      dataType:"text",
      success: function (response) {
        var json = $.parseJSON(response);
        console.log(json[0].pseudo);

        for (var i = 0; i < json.length; i++) {
        $("#pseudo option:selected").append(
            '<p>'+json[i].pseudo+'</p>'
        );
        }
              
         
      } 
    });

  


   }
   else
   {
    $('#res').html("Cherchez un nom d'utilisateur");
   }
}

</script>

<script src="js/jquery.js"></script>

<?php require 'elements/footer.php';?>
 