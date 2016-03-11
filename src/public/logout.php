<?php
require_once("../includes/general_functions.php");
// completely destroy the session


// set session to empty array
$_SESSION = array();

// if cookie with that session name exists make it expire
if (isset($_COOKIE[session_name()])) {
setcookie(session_name(), '', time() - 42000, '/');
}

// destroys the session file on the server
session_destroy();

redirect_to("loginPage.php");
?>