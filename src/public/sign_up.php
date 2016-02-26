<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/general_functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
// initialize variables we may want to redisplay if the user has previously made entry errors
$userName = "";
$fName = "";
$lName = "";
$userEmail = "";

if (isset($_POST["submit"])) {

    // process the form

    // carry out form validations

    // ensure no fields are empty

    // ensure passwords match

    if (empty($errors)) {


        // set variables for SQL insert query
        $userName = mysql_prep($_POST["username"]);
        $fName = mysql_prep($_POST["first_name"]);
        $lName = mysql_prep($_POST["last_name"]);
        $password = password_encrypt($_POST["password"]);
        $userEmail = mysql_prep($_POST["email"]);


        $query = "INSERT INTO User (";
        $query .= "userName, fName, lName, userPassword, userEmail";
        $query .= ") VALUES (";
        $query .= "'{$userName}', '{$fName}', '{$lName}', '{$password}', '{$userEmail}'";
        $query .= ")";

        $user_id = mysqli_insert_id($connection);

        $query .= "INSERT INTO Role (";
        $query .= "userID, typeID";
        $query .= ") VALUES (";
        $query .= ""

        $result = mysqli_query($connection, $query);

        if ($result) {
            // Success
            $_SESSION["message"] = "Welcome .";
            // TODO change to user's home page. Need to store user id as well
            redirect_to("../index.php");
        } else {
            // Failure
            $message = "Failed to create account. Please try again.";
            // TODO redirect user to login screen

        }

    }


} ?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
<?php echo $query; ?>
<br/>
<?php print_r(mysqli_error($connection)); ?>
<div class="formContainer">
    <h2 class="formHeader">Register An Account</h2>
    <form class="SignupForm" action="sign_up.php" method="post">
        <div>
            <h3>First Name</h3>
            <input type="text" name="first_name" value="<?php echo htmlentities($fName); ?>"/>
        </div>
        <div>
            <h3>Last Name</h3>
            <input type="text" name="last_name" value="<?php echo htmlentities($lName); ?>"/>
        </div>
        <div>
            <h3>Email Address</h3>
            <input type="text" name="email" value="<?php echo htmlentities($userEmail); ?>"/>
        </div>
        <div>
            <h3>Username</h3>
            <input type="text" name="username" value="<?php echo htmlentities($userName); ?>"/>
        </div>
        <div>
            <h3>Password</h3>
            <input type="text" name="password" value=""/>
        </div>
        <div>
            <h3>Confirm Password</h3>
            <input type="text" name="password_confirmation" value=""/>
        </div>
        <div>
            <input type="submit" name="submit" value="Sign Up"/>
        </div>

    </form>


</div>
</body>
</html>
