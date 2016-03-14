<?php
require_once("../includes/session.php");
require_once("../includes/db_connection.php");
require_once("../includes/general_functions.php");
require_once("../includes/validation_functions.php");
require_once("../includes/user.php");
?>

<?php
if (isset($_POST['submit'])) {
    // process the form

    // VALIDATION

    // check if login fields are empty
    $required_fields = array("username", "password");
    validate_presences($required_fields);

    // check if username and password entries exceed character limit
    $fields_with_max_lengths = array("username" => 255, "password" => 255);
    validate_max_lengths($fields_with_max_lengths);


    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        redirect_to("loginPage.php");
    }

    // set variables to validate user
    $username = $_POST["username"];
    $password = $_POST["password"];


    // Attempt login
    if ($valid_user = attempt_login($username, $password)) {
        // Success
        // Mark user as logged in
        $user = find_user_by_username($username);
        $_SESSION["userID"] = $user["userID"];
        $_SESSION["username"] = $user["userName"];
        $_SESSION["password"] = $password;
        // clear error messages
        $_SESSION["errors"] = "";

        redirect_to("auction_list.php");
    } else {
        // Failure
        $_SESSION["errors"][] = "Username and password is incorrect.";
        redirect_to("loginPage.php");


    }


}
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Page</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
    <link href="../css/create_auctionStyling.css" rel="stylesheet"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->

</head>

<body style="background-color: #dbdbdb">

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="box-shadow: 0px 0px 10px #606060">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#"><img class="navbar-brand" src="../../images/logo2.png" style="padding: 4px"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<div class="container-fluid" align="center">

    <div class="panel panel-default panel-shadow" style="width: 300px">
        <div class="container-fluid" align="center">
            <img src="../images/logo2.png" class="img-responsive center-block">
        </div>
        <hr>
        <form class="form" action="loginPage.php" method="post">
            <h3 class="text-inverse" align="left">Username</h3>
            <input class="input-lg" type="text" name="username" placeholder="Username"><br>
            <h3 class="text-inverse" align="left">Password</h3>
            <input class="input-lg" type="password" name="password" placeholder="Password"><br><br>
            <input class="btn-gold btn-lg" type="submit" name="submit" value="Log in" >
            <input class="btn-gold btn-lg" type="submit" href="sign_up.php" value="Sign Up" >
        </form><!-- all forms include a submit button -->
    </div>
</div>

<div class="text-danger" align="center">
    <?php echo form_errors(errors()); ?></div>
</body>

</html>