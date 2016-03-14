<?php
$DBservername = "localhost";
$DBusername = "root";
$DBpassword = "password";
$DBname = "AuctionSite";

// Create connection
$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>