<?php
session_start();

// returns message string stored in $_SESSION['message']
function message() {
    if (isset($_SESSION["message"])) {
        $output = "<div class=\"message\">";
        $output .= htmlentities($_SESSION["message"]);
        $output .= "</div>";

        // clear message after use
        $_SESSION["message"] = null;

        return $output;
    }
}

// returns array of error messages stored in $_SESSION['errors']
function errors() {
    if (isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];

        // clear message after use
        $_SESSION["errors"] = null;

        return $errors;
    }
}

?>