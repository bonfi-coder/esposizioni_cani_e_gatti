<?php
include('session.php');
$insert = "";
$sql = "SELECT IdUtente FROM utente WHERE username = '$login_session'";
$result = mysqli_query($db, $sql);
$IdUtente = mysqli_fetch_assoc($result);
$current_date = date ("Y-m-d");
if(isset($_POST["confermaConcorso"])){
    if ((!(empty($_POST["descrizioneConcorso"])) && !(empty($_POST["animaleConcorso"])) && !(empty($_POST["dataConcorso"])) && !(empty($_POST["luogoConcorso"])) && !(empty($_FILES["immagineConcorso"])) && !(empty($_POST["categoriaConcorso"])))){
        $descrizioneConcorso = $_POST["descrizioneConcorso"];
        $animaleConcorso = $_POST["animaleConcorso"];
        $dataConcorso = $_POST["dataConcorso"];
        $luogoConcorso = $_POST["luogoConcorso"];
        $categoriaConcorso = $_POST["categoriaConcorso"];
        $image = $_FILES['immagineConcorso'];
        move_uploaded_file($image['tmp_name'],"images/".$image['name']);
        $immagineConcorso = $image['name'];
        $sql = "INSERT INTO concorso VALUES (DEFAULT, '$descrizioneConcorso', '$animaleConcorso', '$categoriaConcorso', '$luogoConcorso', '$dataConcorso' ,'$immagineConcorso')";
        mysqli_query($db, $sql);
    }
}
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
                <li><a href="#concorsi">Concorsi</a></li>
                <li><a href="#utenti">Utente</a></li>
                <li><a href="#gatti">Gatti</a></li>
                <li><a href="#cani">Cani</a></li>
                <li><a href="./login.php">Logout</a></li>
            </ul>
            </div>
        </div>
        </nav>

        <!-- Container (The Profile Section) -->
        <div id="animalSection" class="container text-center">
            <h3>Welcome <?php echo $login_session; ?></h3>
            <p><em>Anche tu ami gli animali</em></p>
            <p>Da questa pagina puoi amministrare tutte le funzioni del sito</p>
            <br>
        </div>

        <!-- Container (Concorsi Section) -->
        <div id="concorsi" class="bg-1">
        <div class="container">
            <h3 class="text-center">CONCORSI</h3>
            <div class="text-center"><a type="button" class='btn text-center' data-toggle='modal' data-target='#ConcorsoModal'>Aggiungi un concorso!</a></div>
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
                echo "<p><strong>Id concorso:" . $IdConcorso . "</strong></p>\n";
                echo "<p>Descrizione: " . $descrizione . "</p>\n";
                echo "<p>Riservato a: " . $animale . "</p>\n";
                echo "<p>Data: " . $data . "</p>\n";
                echo "<p>Luogo: " . $luogo . "</p>\n";
                if (strtotime($row["data"]) > strtotime($current_date)){
                    echo "<span class='label label-success'>Open!</span>";
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
        </div>

        <!-- Container (Sezione Utenti) -->
        <div id="utenti" class="bg-1">
        <div class="container">
            <h3 class="text-center">Utenti</h3>
            <form method="post">
                <div class="input-group">
                    <input type="text" class="form-control rounded" placeholder="Example: 1/2/3" name="utenteDaCercare" style="width: 400px;"/>
                    <button type="submit" class="btn btn-outline-primary" name="cercaUtente" id="cercaUtente">Cerca</button>
                </div>
                <?php echo "<h3>". $insert . "</h3>\n"?>
            </form>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">IdUtente</th>
                <th scope="col">username</th>
                <th scope="col">password</th>
                <th scope="col">ruolo</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (isset($_POST["cercaUtente"])){
                    $IdUtente = $_POST['utenteDaCercare'];
                    $sql = "SELECT * FROM utente WHERE IdUtente = $IdUtente";
                    $result = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        $IdUtente = $row["IdUtente"];
                        $username = $row["username"];
                        $password = $row["password"];
                        $ruolo = $row["ruolo"];
                        echo "<tr>  \n";
                        echo "<td>" . $IdUtente . "</td> \n";
                        echo "<td>" . $username . "</td> \n";
                        echo "<td>" . $password . "</td> \n";
                        echo "<td>" . $ruolo . "</td> \n";
                        echo "</tr> \n";
                    }
                }
            ?>
            </tbody>
        </table>
        </div>
        </div>

        <!-- Container (Sezione Gatti) -->
        <div id="gatti" class="bg-1">
        <div class="container">
            <h3 class="text-center">Gatti</h3>
            <form method="post">
                <div class="input-group">
                    <input type="text" class="form-control rounded" placeholder="Example: 1/2/3" name="gattoDaCercare" style="width: 400px;"/>
                    <button type="submit" class="btn btn-outline-primary" name="cercaGatto" id="cercaGatto">Cerca</button>
                </div>
                <?php echo "<h3>". $insert . "</h3>\n"?>
            </form>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">IdGatto</th>
                <th scope="col">nome</th>
                <th scope="col">genere</th>
                <th scope="col">razza</th>
                <th scope="col">proprietario</th>
                <th scope="col">immagine</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (isset($_POST["cercaGatto"])){
                    $IdGatto = $_POST['gattoDaCercare'];
                    $sql = "SELECT * FROM gatto WHERE IdGatto = $IdGatto";
                    $result = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        $IdGatto = $row["IdGatto"];
                        $nome = $row["nome"];
                        $genere = $row["genere"];
                        $razza = $row["razza"];
                        $immagine = $row["immagine"];
                        $proprietario = $row["proprietario"];
                        echo "<tr>  \n";
                        echo "<td>" . $IdGatto . "</td> \n";
                        echo "<td>" . $nome . "</td> \n";
                        echo "<td>" . $genere . "</td> \n";
                        echo "<td>" . $razza . "</td> \n";
                        echo "<td>" . $proprietario . "</td> \n";
                        echo "<td>" . $immagine . "</td> \n";
                        echo "</tr> \n";
                    }
                }
            ?>
            </tbody>
        </table>
        </div>
        </div>

        <!-- Container (Sezione Cani) -->
        <div id="cani" class="bg-1">
        <div class="container">
            <h3 class="text-center">Cani</h3>
            <form method="post">
                <div class="input-group">
                    <input type="text" class="form-control rounded" placeholder="Example: 1/2/3" name="caneDaCercare" style="width: 400px;"/>
                    <button type="submit" class="btn btn-outline-primary" name="cercaCane" id="cercaCane">Cerca</button>
                </div>
                <?php echo "<h3>". $insert . "</h3>\n"?>
            </form>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">IdCane</th>
                <th scope="col">Nome</th>
                <th scope="col">Genere</th>
                <th scope="col">Razza</th>
                <th scope="col">Proprietario</th>
                <th scope="col">Immagine</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (isset($_POST["cercaCane"])){
                    $IdCane = $_POST['caneDaCercare'];
                    $sql = "SELECT * FROM cane WHERE IdCane = $IdCane";
                    $result = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        $IdCane = $row["IdCane"];
                        $nome = $row["nome"];
                        $genere = $row["genere"];
                        $razza = $row["razza"];
                        $proprietario = $row["proprietario"];
                        $immagine = $row["immagine"];
                        echo "<tr>  \n";
                        echo "<td>" . $IdCane . "</td> \n";
                        echo "<td>" . $nome . "</td> \n";
                        echo "<td>" . $genere . "</td> \n";
                        echo "<td>" . $razza . "</td> \n";
                        echo "<td>" . $proprietario . "</td> \n";
                        echo "<td>" . $immagine . "</td> \n";
                        echo "</tr> \n";
                    }
                }
            ?>
            </tbody>
        </table>
        </div>
        </div>

        <!-- Container (Sezione Concorsi) -->
        <div id="utenti" class="bg-1">
        <div class="container">
            <h3 class="text-center">Concorsi</h3>
            <form method="post">
                <div class="input-group">
                    <input type="text" class="form-control rounded" placeholder="Example: 1/2/3" name="concorsoDaCercare" style="width: 400px;"/>
                    <button type="submit" class="btn btn-outline-primary" name="cercaConcorso" id="cercaConcorso">Cerca</button>
                </div>
                <?php echo "<h3>". $insert . "</h3>\n"?>
            </form>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">IdConcorso</th>
                <th scope="col">descrizione</th>
                <th scope="col">Animale</th>
                <th scope="col">Categoria</th>
                <th scope="col">Luogo</th>
                <th scope="col">Data</th>
                <th scope="col">Immagine</th>
                <th scope="col">Stato</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (isset($_POST["cercaConcorso"])){
                    $concorso = $_POST["concorsoDaCercare"];
                    $sql = "SELECT * FROM concorso WHERE IdConcorso = $concorso";
                    $result = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        $IdConcorso = $row["IdConcorso"];
                        $descrizione = $row["descrizione"];
                        $immagine = $row["immagine"];
                        $animale = $row["animale"];
                        $categoria = $row["categoria"];
                        $luogo = $row["luogo"];
                        $data = $row["data"];
                        echo "<tr>  \n";
                        echo "<td>" . $IdConcorso . "</td> \n";
                        echo "<td>" . $descrizione . "</td> \n";
                        echo "<td>" . $animale . "</td> \n";
                        echo "<td>" . $categoria . "</td> \n";
                        echo "<td>" . $luogo . "</td> \n";
                        echo "<td>" . $data . "</td> \n";
                        echo "<td>" . $immagine . "</td> \n";
                        if (strtotime($row["data"]) > strtotime($current_date)){
                            echo "<td>Open!</td> \n";
                        }else{
                            echo "<td>Expired!</td> \n";;
                        }
                        echo "</tr> \n";
                    }
                }
            ?>
            </tbody>
        </table>
        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ConcorsoModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4><span class="glyphicon glyphicon-lock"></span>Nuovo concorso</h4>
                </div>
                <div class="modal-body">
                <form role="form" method="POST" action="welcome_admin.php" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="descrizioneConcorso">Descrizione concorso</label>
                    <input type="text" class="form-control" id="descrizioneConcorso" name="descrizioneConcorso" placeholder="Concorso cani 2020">
                    </div>
                    <div class="form-group">
                    <label for="animaleConcorso">Concorso riservato a</label>
                    <select class="form-select" aria-label="Default select example" id="animaleConcorso" name="animaleConcorso">
                        <option selected>Seleziona...</option>
                        <option value="cani">Cani</option>
                        <option value="gatti">Gatti</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="categoriaConcorso">Categoria concorso</label>
                    <select class="form-select" aria-label="Default select example" id="categoriaConcorso" name="categoriaConcorso">
                        <option selected>Seleziona...</option>
                        <option value="Classe Juniores">Classe Juniores</option>
                        <option value="Gatti di razza">Gatti di razza</option>
                        <option value="Gatti di casa">Gatti di casa</option>
                        <option value="cucciolate e cuccioli dai 3 ai 6 mesi">cucciolate e cuccioli dai 3 ai 6 mesi</option>
                        <option value="classe Ph Premio d’Onore">classe Ph Premio d’Onore</option>
                        <option value="Campionato e Premior">Campionato e Premior</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="luogoConcorso">Luogo</label>
                    <input type="text" class="form-control" id="luogoConcorso" name="luogoConcorso" placeholder="Bovolone">
                    </div>
                    <div class="form-group">
                    <label for="dataConcorso">Data formato YYYY-MM-DD</label>
                    <input type="text" class="form-control" id="dataConcorso" name="dataConcorso" placeholder="Inserisci la data del concorso">
                    </div>
                    <div class="form-group">
                    <label>Immagine concorso: </label><input type="file" id="immagineConcorso" name="immagineConcorso" />
                    </div>
                    <button type="submit" class="btn btn-block" id="confermaConcorso" name="confermaConcorso">Conferma 
                    <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </form>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Cancel
                </button>
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