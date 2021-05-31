<?php
include('session.php');
$sql = "SELECT IdUtente FROM utente WHERE username = '$login_session'";
$result = mysqli_query($db, $sql);
$IdUtente = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Concorsi esposizioni cani e gatti</title>
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
                <li><a href="#myPage">Home</a></li>
                <li><a href="#Concorsi">Concorsi</a></li>
                <li><a href="./login.php">Logout</a></li>
            </ul>
            </div>
        </div>
        </nav>
        <!-- Container (Concorsi Section) -->
        <div id="Concorsi" class="bg-1">
        <div class="container">
            <h3 class="text-center">CONCORSI</h3>
            <div class="text-center">
            <a type="button" class='btn text-center' href="./welcome_user.php#myPage">Ritorna alla tua area personale!</a>
            </div>
            <p class="text-center">Ricorda di iscrivere il tuo migliore amico!</p>
            <ul class="list-group">
            <?php
                $sql = "SELECT COUNT(*) as numeroDiConcorsi FROM concorso WHERE data = CURDATE()";
                $result = mysqli_query($db, $sql);
                if ($row = mysqli_fetch_assoc($result)){
                echo "<li class='list-group-item'>". date("F")." <span class='badge'>Concorsi disponibili: ".$row["numeroDiConcorsi"]."</span></li>";
                }
            ?>
            </ul>
            <?php
            $current_date = date ("Y-m-d");
            $sql = "SELECT * FROM concorso";
            $result = mysqli_query($db, $sql);
            $count = 0;
            echo "<div class='row text-center'>\n";
            while($row = mysqli_fetch_assoc($result)){
                $count++;
                $IdConcorso = $row["IdConcorso"];
                $descrizione = $row["descrizione"];
                $immagine = $row["immagine"];
                $animale = $row["animale"];
                $categoria = $row["categoria"];
                $luogo = $row["luogo"];
                $data = $row["data"];
                echo "<div class='col-sm-4'>\n";
                echo "<div class='thumbnail'>\n";
                echo "<img src='./images/" . $immagine . "' alt='". $luogo . "' style='width: 300px; height: 300px'>\n";
                echo "<p><strong>IdConcorso: " . $IdConcorso . "</strong></p>\n";
                echo "<p>Descrizione: " . $descrizione . "</p>\n";
                echo "<p>Categoria: " . $categoria . "</p>\n";
                echo "<p>Data: " . $data . "</p>\n";
                echo "<p>Luogo: " . $luogo . "</p>\n";
                if (strtotime($row["data"]) > strtotime($current_date)){
                    if ($animale == "cani"){
                        echo "<a type='button' class='btn text-center' href='iscrizione.php?IdConcorso=$IdConcorso&animale=$animale&descrizione=$descrizione&categoria=$categoria'>Iscrivi il tuo cane!</a>";
                    }else{
                        echo "<a type='button' class='btn text-center' href='iscrizione.php?IdConcorso=$IdConcorso&animale=$animale&descrizione=$descrizione&categoria=$categoria'>Iscrivi il tuo gatto!</a>";
                    }
                }else{
                    echo "<span class='label label-danger'>Expired!</span>";
                }
                echo "</div>\n";
                echo "</div>\n";
                if ($count == 3){
                    $count = 0;
                    echo "</div>\n";
                    echo "<div class='row text-center'>\n";
                }

            }
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4><span class="glyphicon glyphicon-lock"></span>Iscrizione</h4>
                </div>
                <div class="modal-body">
                <form role="form" method="POST" action="iscrizione.php" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="nomeAnimale"><span class="glyphicon glyphicon-user"></span>Nome animale</label>
                    <input type="text" class="form-control" id="nomeAnimale" name="nomeAnimale" placeholder="Inserisci il nome del tuo animale">
                    </div>
                    <div class="form-group">
                    <label for="categoriaConcorso"><span class="glyphicon glyphicon-user"></span>Categoria concorso</label>
                    <select class="form-select" aria-label="Default select example" id="categoriaConcorso" name="categoriaConcorso">
                        <option selected>Seleziona...</option>
                        <option value="cane">cane</option>
                        <option value="gatto">gatto</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="genereAnimale"><span class="glyphicon glyphicon-user"></span>Genere</label>
                    <input type="text" class="form-control" id="genereAnimale" name="genereAnimale" placeholder="Genere animale">
                    </div>
                    <div class="form-group">
                    <label for="razzaAnimale"><span class="glyphicon glyphicon-user"></span>Razza</label>
                    <input type="text" class="form-control" id="razzaAnimale" name="razzaAnimale" placeholder="Inserisci la razza del tuo animale">
                    </div>
                    <div class="form-group">
                    <label><span class="glyphicon glyphicon-user"></span>Immagine animale: </label><input type="file" id="immagineAnimale" name="immagineAnimale" />
                    </div>
                    <button type="submit" class="btn btn-block" id="confermaIscrizione" name="confermaIscrizione">Conferma 
                    <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </form>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Cancel
                </button>
                <p>Need <a href="#">help?</a></p>
                </div>
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
    </body>
</html>
