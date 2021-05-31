<?php
include('session.php');
$sql = "SELECT * FROM concorso";
$result = mysqli_query($db, $sql);
$numeroConcorsi = mysqli_num_rows($result);
$sql = "SELECT IdUtente FROM utente WHERE username = '$login_session'";
$result = mysqli_query($db, $sql);
$IdUtente = mysqli_fetch_assoc($result);
$IdUtente = $IdUtente["IdUtente"];
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
                    <li><a href="#sezioneCani">Dogs & Cats</a></li>
                    <li><a href="#Concorsi">Concorsi</a></li>
                    <li><a href="#Iscrizioni">Iscrizioni</a></li>
                    <li><a href="./login.php">Logout</a></li>
                </ul>
                </div>
            </div>
        </nav>
        <!-- Container (The "Your animal" Section) -->
        <div id="animalSection" class="container text-center">
            <h3>Welcome <?php echo $login_session; ?></h3>
            <p><em>Anche tu ami gli animali</em></p>
            <p>In questa sezione troverai tutti i tuoi animali che hai registrato nel database</p>
            <br>
        </div>
        <!-- Container (Sezione cani) -->
        <div id="sezioneCani" class="bg-1">
            <div class="container">
                <h3 class="text-center">I tuoi cani</h3>
                <?php
                $sql = "SELECT * FROM cane WHERE proprietario = $IdUtente";
                $result = mysqli_query($db, $sql);
                echo "<div class='row text-center'>\n";
                while($row = mysqli_fetch_assoc($result)){
                    $IdCane = $row["IdCane"];
                    $nome = $row["nome"];
                    $razza = $row["razza"];
                    $genere = $row["genere"];
                    $image = $row["immagine"];
                    echo "<div class='col-sm-4'>\n";
                    echo "<div class='thumbnail'>\n";
                    echo "<img src='./images/" . $image . "' style='width: 250px; height: 250px'>\n";
                    echo "<p>IdAnimale: <strong>" . $IdCane . "</strong></p>\n";
                    echo "<p>Nome: " . $nome . "</p>\n";
                    echo "<p>Genere: " . $genere . "</p>\n";
                    echo "<p>Razza: " . $razza . "</p>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
                echo "</div>";
                ?>
            </div>
        </div>

        <!-- Container (Sezione gatti) -->
        <div id="sezioneGatti" class="bg-1">
            <div class="container">
                <h3 class="text-center">I tuoi gatti</h3>
                <?php
                $sql = "SELECT * FROM gatto WHERE proprietario = $IdUtente";
                $result = mysqli_query($db, $sql);
                echo "<div class='row text-center'>\n";
                while($row = mysqli_fetch_assoc($result)){
                    $IdGatto = $row["IdGatto"];
                    $nome = $row["nome"];
                    $razza = $row["razza"];
                    $genere = $row["genere"];
                    $image = $row["immagine"];
                    echo "<div class='col-sm-4'>\n";
                    echo "<div class='thumbnail'>\n";
                    echo "<img src='./images/" . $image . "' style='width: 250px; height: 250px'>\n";
                    echo "<p>IdAnimale: <strong>" . $IdGatto . "</strong></p>\n";
                    echo "<p>Nome: " . $nome . "</p>\n";
                    echo "<p>Genere: " . $genere . "</p>\n";
                    echo "<p>Razza: " . $razza . "</p>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
                echo "</div>";
                ?>
            </div>
        </div>

        <!-- Container (Concorsi Section) -->
        <div id="Concorsi" class="bg-1">
            <div class="container">
                <h3 class="text-center">CONCORSI</h3>
                <div class="text-center">
                <a type="button" class='btn text-center' href="./concorsi.php">Vedi tutti i concorsi!</a>
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
                    if (strtotime($row["data"]) > strtotime($current_date)){
                    $count++;
                    $IdConcorso = $row["IdConcorso"];
                    $descrizione = $row["descrizione"];
                    $immagine = $row["immagine"];
                    $categoria = $row["categoria"];
                    $animale = $row["animale"];
                    $luogo = $row["luogo"];
                    $data = $row["data"];
                    echo "<div class='col-sm-4'>\n";
                    echo "<div class='thumbnail'>\n";
                    echo "<img src='./images/" . $immagine . "' style='width: 300px; height: 300px'>\n";
                    echo "<p>IdConcorso: <strong>" . $IdConcorso . "</strong></p>\n";
                    echo "<p>Descrizione: " . $descrizione . "</p>\n";
                    echo "<p>Categoria: " . $categoria . "</p>\n";
                    echo "<p>Data: " . $data . "</p>\n";
                    echo "<p>Luogo: " . $luogo . "</p>\n"; 
                    if ($animale == "cani"){
                        echo "<a type='button' class='btn text-center' href='iscrizione.php?IdConcorso=$IdConcorso&animale=$animale&descrizione=$descrizione&categoria=$categoria'>Iscrivi il tuo cane!</a>";
                    }else{
                        echo "<a type='button' class='btn text-center' href='iscrizione.php?IdConcorso=$IdConcorso&animale=$animale&descrizione=$descrizione&categoria=$categoria'>Iscrivi il tuo gatto!</a>";
                    }
                    echo "</div>\n";
                    echo "</div>\n";
                    if ($count == 3){
                        $count = 0;
                        echo "</div>\n";
                        echo "<div class='row text-center'>\n";
                    }
                    }
                }
                ?>
            </div>
        </div>

        <!-- Sezione iscrizioni gatti -->
        <div id="Iscrizioni">
            <div class="bg-1">
            <div class="container">
                <h3 class="text-center">ISCRIZIONI</h3>
                <p class="text-center">Iscrizioni gatti</p>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">IdAnimale</th>
                        <th scope="col">Nome</th>
                        <th scope="col">IdConcorso</th>
                        <th scope="col">Concorso</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql = "SELECT * FROM iscrizioneGatto WHERE gatto IN (SELECT IdGatto FROM gatto WHERE proprietario = $IdUtente)";
                        $result = mysqli_query($db, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            $IdConcorso = $row["concorso"];
                            $IdGatto = $row["gatto"];
                            $sql = "SELECT nome FROM gatto WHERE IdGatto = $IdGatto";
                            $resultForGatto = mysqli_query($db, $sql);
                            $record = mysqli_fetch_assoc($resultForGatto);
                            $nomeGatto = $record["nome"];
                            $sql = "SELECT descrizione FROM concorso WHERE IdConcorso = $IdConcorso";
                            $resultForCourse = mysqli_query($db, $sql);
                            $record = mysqli_fetch_assoc($resultForCourse);
                            $descrizioneConcorso = $record["descrizione"];
                            echo "<tr>  \n";
                            echo "<td>" . $IdGatto . "</td> \n";
                            echo "<td>" . $nomeGatto . "</td> \n";
                            echo "<td>" . $IdConcorso . "</td> \n";
                            echo "<td>" . $descrizioneConcorso . "</td> \n";
                            echo "</tr> \n";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            </div>

            <!-- Sezione iscrizioni cani-->
            <div class="bg-1">
            <div class="container">
                <p class="text-center">Iscrizioni cani</p>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">IdAnimale</th>
                        <th scope="col">Nome</th>
                        <th scope="col">IdConcorso</th>
                        <th scope="col">Concorso</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql = "SELECT * FROM iscrizioneCane WHERE cane IN (SELECT IdCane FROM cane WHERE proprietario = $IdUtente)";
                        $result = mysqli_query($db, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            $IdConcorso = $row["concorso"];
                            $IdCane = $row["cane"];
                            $sql = "SELECT nome FROM cane WHERE IdCane = $IdCane";
                            $resultForCane = mysqli_query($db, $sql);
                            $record = mysqli_fetch_assoc($resultForCane);
                            $nomeCane = $record["nome"];
                            $sql = "SELECT descrizione FROM concorso WHERE IdConcorso = $IdConcorso";
                            $resultForCourse = mysqli_query($db, $sql);
                            $record = mysqli_fetch_assoc($resultForCourse);
                            $descrizioneConcorso = $record["descrizione"];
                            echo "<tr>  \n";
                            echo "<td>" . $IdCane . "</td> \n";
                            echo "<td>" . $nomeCane . "</td> \n";
                            echo "<td>" . $IdConcorso . "</td> \n";
                            echo "<td>" . $descrizioneConcorso . "</td> \n";
                            echo "</tr> \n";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            </div>
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
                <form role="form" method="POST" action="welcome_user.php" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="nomeAnimale"><span class="glyphicon glyphicon-user"></span>Codice identificativo del concorso</label>
                    <input type="number" min="0" max="<?php echo $numeroConcorsi; ?>" class="form-control" id="IdConcorso" name="IdConcorso" placeholder="IdConcorso">
                    </div>
                    <div class="form-group">
                    <label for="nomeAnimale"><span class="glyphicon glyphicon-user"></span>Nome animale</label>
                    <input type="text" class="form-control" id="nomeAnimale" name="nomeAnimale" placeholder="Inserisci il nome del tuo animale">
                    </div>
                    <div class="form-group">
                    <label for="categoriaConcorso"><span class="glyphicon glyphicon-user"></span>Categoria concorso</label>
                    <select class="form-select" aria-label="Default select example" id="categoriaConcorso" name="categoriaConcorso">
                        <option selected>Seleziona...</option>
                        <option value="cane">Cane</option>
                        <option value="gatto">Gatto</option>
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

        <!-- Modal HTML -->
        <div id="ErrorModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="icon-box">
                            <i class="material-icons">&#xE5CD;</i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Ooops!</h4>	
                        <p>Sembra che tu abbia già registrato un animale con quel nickname!</p>
                        <button class="btn btn-success" data-dismiss="modal">Try Again</button>
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