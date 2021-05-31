<?php
    include("config.php");
    session_start();
    $username_err = $password_err = "";
    $error = "";
    // Login
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      if(!(empty($_POST["usernameLogin"])) && !(empty($_POST["passwordLogin"]))){
        $myusername = mysqli_real_escape_string($db,$_POST['usernameLogin']); // Escape special characters in strings
        $mypassword = mysqli_real_escape_string($db,$_POST['passwordLogin']);

        // Prepared statement for login
        $sql = "SELECT password, ruolo FROM utente WHERE username = ?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "s", $myusername);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($result);
        $hashed_password = $result["password"];
        if(password_verify($mypassword, $hashed_password)) { // verify if the password is correct
          $_SESSION['login_user'] = $myusername;
          if ($result["ruolo"] == "admin"){
            header("location: welcome_admin.php");// redirect to welcome page for admin
          }else{
            header("location: welcome_user.php"); // redirect to welcome page for users
          }
          mysqli_stmt_close($stmt);
          exit();
        }else {
          $error = "Your Login Name or Password is invalid";
        } 
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
            <li><a href="#myPage">Home</a></li>
            <li><a href="#story">Dogs & Cats</a></li>
            <li><a href="#concorsi">Concorsi</a></li>
            <li><a href="#contact">Contatti</a></li>
            <li><a href="#Login">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img src="./images/wallpaper-1.jpg" class="d-block w-100" alt="New York">      
          </div>

          <div class="item">
            <img src="./images/wallpaper-2.jpg" class="d-block w-100" alt="Chicago">     
          </div>
        
          <div class="item">
            <img src="./images/wallpaper-4.jpg" class="d-block w-100" alt="Los Angeles">      
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Container (The Story Section) -->
    <div id="story" class="container text-center">
      <h3>Super Animals</h3>
      <p><em>Noi amiamo gli animali!</em></p>
      <p>Tutto è iniziato con il sogno del nostro fondatore Bonfante Stefano, un vero e proprio amante degli animali, che insieme al nostro staff ha reso possibile il sogno di molti animali, ovvero quello di partecipare a dei veri e propri concorsi di bellezza. Dal 2021 infatti è possibile iscrivere il proprio amico ai concorsi che si terranno regolarmente su tutto il territorio nazionale italiano.</p>
      <br>
      <div class="row">
        <div class="col-sm-4">
          
        </div>
        <div class="col-sm-4">
          <p class="text-center"><strong>Bonfante Stefano</strong></p><br>
          <a href="#demo2" data-toggle="collapse">
            <img src="./images/dino_avatar.png" class="img-circle person" alt="Random Name" width="255" height="255">
          </a>
          <div id="demo2" class="collapse">
            <p>Studente</p>
            <p>Amo i cani e i gatti</p>
            <p>Project manager dal 2021</p>
          </div>
        </div>
        <div class="col-sm-4">
        </div>
      </div>
    </div>

    <!-- Container (Concorsi Section) -->
    <div id="concorsi" class="bg-1">
      <div class="container">
        <h3 class="text-center">CONCORSI</h3>
        <div class="text-center">
          <a type="button" class='btn text-center' href="./login.php#Login">Vedi tutti i concorsi!</a>
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
              if ($animale == "cani"){
                echo "<a type='button' class='btn text-center' href='#Login'>Iscrivi il tuo cane!</a>";
              }else{
                echo "<a type='button' class='btn text-center' href='#Login'>Iscrivi il tuo gatto!</a>";
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

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
      <h3 class="text-center">Contact</h3>
      <p class="text-center"><em>We love our fans!</em></p>
      <div class="row">
        <div class="col-md-4">
          <p><span class="glyphicon glyphicon-map-marker"></span>Verona, IT</p>
          <p><span class="glyphicon glyphicon-envelope"></span>Email: 18174@studenti.marconiverona.edu.it</p>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col map-container">
              <!--Google map-->
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d179149.15737524055!2d10.86049493671496!3d45.44551318664792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477f5f442136c007%3A0xcba10112f3943b62!2sVerona%20VR!5e0!3m2!1sit!2sit!4v1618702630254!5m2!1sit!2sit" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
          </div>
        </div>
      </div>
      <br>
      <h3 class="text-center">From The Blog</h3>  
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Mike</a></li>
        <li><a data-toggle="tab" href="#menu1">Chandler</a></li>
        <li><a data-toggle="tab" href="#menu2">Peter</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <h2>Mike Ross</h2>
          <p>Un lavorone! Continuate cosi.</p>
        </div>
        <div id="menu1" class="tab-pane fade">
          <h2>Chandler Bing</h2>
          <p>Always a pleasure people! Hope you enjoyed it as much as I did. Could I BE.. any more pleased?</p>
        </div>
        <div id="menu2" class="tab-pane fade">
          <h2>Peter Griffin</h2>
          <p>I mean, sometimes I enjoy my house, but other times I enjoy other things.</p>
        </div>
      </div>
    </div>

    <!-- Login form -->
    <div class="modal-dialog" id="Login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">LOGIN</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
          <div class="modal-body">
            <div class="mb-3">
              <label for="usernameLogin" class="form-label">Username</label>
              <input type="text" class="form-control" id="usernameLogin" name="usernameLogin" aria-describedby="usernameHelp">
            </div>
            <div class="mb-3">
              <label for="passwordLogin" class="form-label">Password</label>
              <input type="password" class="form-control" id="passwordLogin" name="passwordLogin">
              <?php echo $error ?>
            </div>
            <div id="signupHelp" class="form-text">
              Not registered?
              <a class="link-primary" href="./registrazione.php#Registrazione">Sign Up</a>
            </div>
            </div>
            <div class="modal-footer">
              <div id="signupHelp" class="form-text">
                <button type="submit" class="btn btn-primary" name="submitLogin" id="submitLogin">Submit</button>
              </div>
            </div>
        </form>
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