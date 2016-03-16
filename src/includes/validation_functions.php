<?php
require_once("db_connection.php");
require_once("general_functions.php");
// stores validation error messages
$errors = array();

function fieldname_as_text($fieldname)
{
    $fieldname = str_replace("_", " ", $fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
}

// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
function has_presence($value)
{
    return isset($value) && $value !== "";
}

function validate_presences($required_fields)
{
    global $errors;
    foreach ($required_fields as $field) {
        $value = trim($_POST[$field]);
        if (!has_presence($value)) {
            $errors[$field] = fieldname_as_text($field) . " can't be blank";
        }
    }
}

// * string length
// max length
function has_max_length($value, $max)
{
    return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths)
{
    global $errors;
    // Expects an assoc. array
    foreach ($fields_with_max_lengths as $field => $max) {
        $value = trim($_POST[$field]);
        if (!has_max_length($value, $max)) {
            $errors[$field] = fieldname_as_text($field) . " is too long";
        }
    }
}

// * inclusion in a set
function has_inclusion_in($value, $set)
{
    return in_array($value, $set);
}

function form_errors($errors = array())
{
    $output = "";
    if (!empty($errors)) {
        $output .= "<div class=\"error\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

// check passwords entered when signup match
function check_password_match($password, $confirmation_password)
{
    global $errors;

    if($password === $confirmation_password){
        return true;
    }else {
        $errors['password'] = "Passwords do not match";
        return false;
    }

}

function validate_email($email) {
    // check if email is well-formed
    global $errors;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['invalid_email'] = "Invalid email format";
        return false;
    } else {
        return true;
    }
}

// checks if username is already in use
function username_exists($username) {
    global $connection;
    global $errors;

    $safe_username = mysql_prep($username);
    $query = "SELECT * FROM Users WHERE userName = '{$username}'";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $errors["existing_username"] = "Username already exists";
        return true;
    } else {
        return false;
    }

}

// checks if entered email is already in use
function email_exists($email) {

    global $connection;
    global $errors;

    $safe_email = mysql_prep($email);

    $query = "SELECT * FROM Users WHERE userEmail = '{$email}'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0 ) {
        $errors["existing_email"] = "This email address is already in use";
        return true;
    } else {
        return false;
    }
}

?>