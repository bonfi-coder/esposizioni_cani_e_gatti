<?php
   // config parameters for the connection to the database
   define('DB_SERVER', '127.0.0.1');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'esposizioni_cani_e_gatti');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
 
// Check connection
   if($db === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
   }
?>