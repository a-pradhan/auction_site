<?php

define("DB_SERVER","127.0.0.1");
define("DB_USER","root");
define("DB_PASS","password");
define("DB_NAME","AuctionSite");

//1.Create database connection
$connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);


//Test if connection occurred
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno . ")"
    );
}

?>



/**
 * Created by PhpStorm.
 * User: sadiq
 * Date: 10/02/16
 * Time: 20:26
 */