<?php

function find_user_by_username($username)
{
    global $connection;
    $safe_username = mysql_prep($username);

    $query = "SELECT * FROM User ";
    $query .= "WHERE userName = '{$safe_username}' ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);

    if ($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return false;
    }

}

// check submitted password with password stored in database
function password_check($password, $existing_hash)
{
    // existing has contains format and salt at start
    $hash = crypt($password, $existing_hash);
    if ($hash === $existing_hash) {
        return true;
    } else {
        return false;
    }


}


// attempts to find user in database and compare entered password with encrypted password
// if comparison is successful the user
function attempt_login($username, $password)
{
    // retrieve user with matching username
    $user = find_user_by_username($username);

    if ($user) {
        // found user, now check password
        if (password_check($password, $user["userPassword"])) {
            // password matches
            return true;
        } else {
            // password does not match
            return false;
        }

    } else {
        // user not found
        return false;
    }
}


?>