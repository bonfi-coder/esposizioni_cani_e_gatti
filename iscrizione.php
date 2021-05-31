<?php
include("session.php");
$IdConcorso = $_GET['IdConcorso'];
$animale = $_GET['animale'];
$categoria = $_GET['categoria'];
$descrizione = $_GET['descrizione'];
$sql = "SELECT IdUtente FROM utente WHERE username = '$login_session'";
$result = mysqli_query($db, $sql);
$IdUtente = mysqli_fetch_assoc($result);
$IdUtente = $IdUtente["IdUtente"];
$tabella = "";
if ($animale == "cani"){
    $tabella = "cane";
}else{
    $tabella = "gatto";
}
if(isset($_POST["confermaIscrizione"])){
    if ((!(empty($_POST["nomeAnimale"])) && !(empty($_POST["genereAnimale"])) && !(empty($_POST["razzaAnimale"])) && !(empty($_FILES["immagineAnimale"])))){
        $nomeAnimale = $_POST["nomeAnimale"];
        $genereAnimale = $_POST["genereAnimale"];
        $razzaAnimale = $_POST["razzaAnimale"];
        $image = $_FILES['immagineAnimale'];
        move_uploaded_file($image['tmp_name'],"images/".$image['name']);
        $immagineAnimale = $image['name'];
        $sql = "SELECT * FROM $tabella WHERE nome='$nomeAnimale' AND proprietario = $IdUtente";
        $result = mysqli_query($db, $sql);
        $countPresence = mysqli_num_rows($result);
        if ($countPresence > 0){
                if ($tabella == "cane"){
                    $sql = "SELECT IdCane FROM cane WHERE nome='$nomeAnimale' AND genere='$genereAnimale' AND razza='$razzaAnimale' AND proprietario=$IdUtente AND immagine='$path'";
                    $result = mysqli_query($db, $sql);
                    $cane = mysqli_fetch_assoc($result);
                    $IdCane = $cane["IdCane"];
                    $sql = "INSERT INTO iscrizione$tabella VALUES ($IdConcorso, $IdCane)";
                    mysqli_query($db, $sql);
                }else{
                    $sql = "SELECT IdGatto FROM gatto WHERE nome='$nomeAnimale' AND genere='$genereAnimale' AND razza='$razzaAnimale' AND proprietario=$IdUtente AND immagine='$path'";
                    $result = mysqli_query($db, $sql);
                    $gatto = mysqli_fetch_assoc($result);
                    $IdGatto = $gatto["IdGatto"];
                    $sql = "INSERT INTO iscrizione$tabella VALUES ($IdConcorso, $IdGatto)";
                    mysqli_query($db, $sql);
                }
        }else{
            $sql = "INSERT INTO $tabella VALUES (DEFAULT, '$nomeAnimale', '$genereAnimale', '$razzaAnimale','$immagineAnimale', $IdUtente)";
            mysqli_query($db, $sql);
            if ($tabella == "cane"){
                $sql = "SELECT IdCane FROM cane ORDER BY IdCane DESC LIMIT 1";
                $result = mysqli_query($db, $sql);
                $cane = mysqli_fetch_assoc($result);
                $IdCane = $cane["IdCane"];
                $sql = "INSERT INTO iscrizione$tabella VALUES ($IdConcorso, $IdCane)";
                mysqli_query($db, $sql);
            }else{
                $sql = "SELECT IdGatto FROM gatto ORDER BY IdGatto DESC LIMIT 1";
                $result = mysqli_query($db, $sql);
                $gatto = mysqli_fetch_assoc($result);
                $IdGatto = $gatto["IdGatto"];
                $sql = "INSERT INTO iscrizione$tabella VALUES ($IdConcorso, $IdGatto)";
                mysqli_query($db, $sql); 
            }
        }
        header("location: welcome_user.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Esposizioni cani e gatti</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="styles.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <a class="navbar-brand" href="#myPage">Super Animals</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="link-primary" href="#">Home</a></li>
                    <li><a class="link-primary" href="welcome_user.php">Area personale</a></li>
                </ul>
                </div>
            </div>
        </nav>
        <!-- Modal -->
        <div class="container">
        <div class="modal-dialog">
                
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4><span class="glyphicon glyphicon-lock"></span>Iscrizione</h4>
                    <p>IdConcorso: <?= $IdConcorso ?></p>
                    <p>Descrizione: <?= $descrizione ?></p>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nomeAnimale">Nome animale</label>
                            <input type="text" class="form-control" id="nomeAnimale" name="nomeAnimale" placeholder="Inserisci il nome del tuo animale">
                        </div>
                        <div class="form-group">
                            <label for="genereAnimale">Genere</label>
                            <input type="text" class="form-control" id="genereAnimale" name="genereAnimale" placeholder="Genere animale">
                        </div>
                        <div class="form-group">
                            <label for="razzaAnimale">Razza</label>
                            <input type="text" class="form-control" id="razzaAnimale" name="razzaAnimale" placeholder="Inserisci la razza del tuo animale">
                        </div>
                        <div class="form-group">
                            <label>Immagine animale: </label><input type="file" id="immagineAnimale" name="immagineAnimale" />
                        </div>
                        <button type="submit" class="btn btn-block" id="confermaIscrizione" name="confermaIscrizione">Conferma 
                        <span class="glyphicon glyphicon-ok"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>

        <!-- Footer -->
        <footer class="text-center">
            <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a><br><br>
            <p>Copyright 2021 © All rights reserved. Powered by Bonfante Stefano</p> 
        </footer>

        <script>
            $(document).ready(function(){
            // Initialize Tooltip
            $('[data-toggle="tooltip"]').tooltip(); 
            
            // Add smooth scrolling to all links in navbar + footer link
            $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {

                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 900, function(){
            
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
                } // End if
            });
            })
      </script>
    </body>
</html>