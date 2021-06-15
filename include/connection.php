<?php 
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PWD","");
define("DB_NAME","cms");

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() .
          " (" . mysqli_connect_errno() . ")"
    );
}

?>