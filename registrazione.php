<?php
include("config.php");
$username_err = $password_err = $confirm_password_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["registrationButton"])){
    // Validate username
    if(empty(trim($_POST["usernameSignUp"]))){
      $username_err = "Please enter a username.";
    } else{
      // Prepared statement to search a user
      $sql = "SELECT IdUtente FROM utente WHERE username = ?";
      if($stmt = mysqli_prepare($db, $sql)){
          mysqli_stmt_bind_param($stmt, "s", $param_username);
          $param_username = trim($_POST["usernameSignUp"]);
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              // store result
              mysqli_stmt_store_result($stmt);
              if(mysqli_stmt_num_rows($stmt) == 1){ // Controls if there is a user with the username given by the form
                  $username_err = "This username is already taken.";
              } else{
                  $username = trim($_POST["usernameSignUp"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
          // Close statement
          mysqli_stmt_close($stmt);
      }
    }
    // Validate password
    if(empty(trim($_POST["passwordSignUp"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["passwordSignUp"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["passwordSignUp"]);
    }
    // Validate confirm password
    if(empty(trim($_POST["passwordSignUpConfirm"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["passwordSignUpConfirm"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        // Prepared statement for registration
        $sql = "INSERT INTO utente (username, password, ruolo) VALUES (?, ?, 'utente')";
        if($stmt = mysqli_prepare($db, $sql)){

            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $param_username = $username;
            $param_password = $hashed_password;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php#Login");
            } else{
                echo "Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($db);
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
                  <li><a class="link-primary" href="">Home</a></li>
                  <li><a class="link-primary" href="./login.php">Login</a></li>
              </ul>
              </div>
          </div>
      </nav>
      <!-- Register model dialog -->
      <div class="container">
        <div class="modal-dialog" id="Registrazione">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">SIGN UP</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
              <div class="modal-body">
                  <div class="mb-3">
                    <label for="usernameSignUp" class="form-label">Username</label>
                    <input type="text" class="form-control" id="usernameSignUp" name="usernameSignUp" aria-describedby="emailHelp">
                    <?php echo $username_err ?>
                  </div>
                  <div class="mb-3">
                    <label for="passwordSignUp" class="form-label">Password</label>
                    <input type="password" class="form-control" id="passwordSignUp" name="passwordSignUp">
                    <div id="passwordSignUpHelp" class="form-text">At least 8 characters.</div>
                    <?php echo $password_err ?>
                  </div>
                  <div class="mb-3">
                    <label for="passwordSignUpConfirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="passwordSignUpConfirm" name="passwordSignUpConfirm">
                    <?php echo $confirm_password_err ?>
                  </div>
              </div>
              <div class="modal-footer">
                <button id="registrationButton" name="registrationButton" type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
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