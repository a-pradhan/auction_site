<?php

// redirects user to specified location
function redirect_to($new_location)
{
    header("Location: " . $new_location);
    exit;
}

// escapes characters that may interfere with SQL queries
function mysql_prep($string)
{
    global $connection;

    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}

// creates a pseudo-random salt to be used for password generation
function generate_salt($length)
{
    // Not 100% unique, not 100% random, but good enough for a salt
    // MD5 returns 32 characters
    $unique_random_string = md5(uniqid(mt_srand(), true));

    // Valid characters for a salt are [a-zA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);

    // But not '+' which is valid in base64 encoding
    $modified_base64_string = str_replace('+', '.', $base64_string);

    // Truncate string to the correct length
    $salt = substr($modified_base64_string, 0, $length);
    return $salt;
}

// encrypts the password using a randomly generated salt
function password_encrypt($password)
{
    $hash_format = "$2y$10$"; // Tells PHP to use Blowfish with a "cost" of 10.
    $salt_length = 22; // Blowfish salts should be 22-characters or more
    $salt = generate_salt($salt_length); // generate a random salt
    $format_and_salt = $hash_format . $salt;
    $hash = crypt($password, $format_and_salt);
    return $hash;
}


?>