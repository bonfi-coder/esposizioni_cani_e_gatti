<?php
   include('config.php');
   session_start();
   
   $user_check = $_SESSION['login_user']; // current logged user
   
   $ses_sql = mysqli_query($db,"SELECT username FROM utente WHERE username = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   
   if(!isset($user_check)){ // if $user_check not set return to login.php
      header("location:login.php");
      die();
   }
?>