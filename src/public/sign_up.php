<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/general_functions.php"); ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
// initialize variables we may want to redisplay if the user has previously made entry errors
$userName = "";
$fName = "";
$lName = "";
$userEmail = "";


if (isset($_POST["submit"])) {
// VALIDATION

    // check if login fields are empty
    $required_fields = ["first_name", "last_name", "username", "email", "password", "password_confirmation"];
    validate_presences($required_fields);

    // check if fields exceed character limit
    $fields_with_max_lengths = ["first_name" => 255, "last_name" => 255, "username" => 255, "password" => 255];
    validate_max_lengths($fields_with_max_lengths);

    // check email format is valid

    // check that both passwords entered match
    check_password_match($_POST['username'], $_POST['password_confirmation']);

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        redirect_to("sign_up.php");
    }


    // set variables for SQL insert query, check for sql injection
    $userName = mysql_prep($_POST["username"]);
    $fName = mysql_prep($_POST["first_name"]);
    $lName = mysql_prep($_POST["last_name"]);
    $password = password_encrypt($_POST["password"]);
    $userEmail = mysql_prep($_POST["email"]);

    // create user account
    $query = "INSERT INTO User (";
    $query .= "userName, fName, lName, userPassword, userEmail";
    $query .= ") VALUES (";
    $query .= "'{$userName}', '{$fName}', '{$lName}', '{$password}', '{$userEmail}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    $user_id = (int)mysqli_insert_id($connection);

    // create user's Buyer account
    $query1 = "INSERT INTO Role (";
    $query1 .= "userID, typeID";
    $query1 .= ") VALUES (";
    $query1 .= $user_id . ", 'Buyer')";
    $buyer_creation = mysqli_query($connection, $query1);

    // create user's Seller account
    $query2 = "INSERT INTO Role (";
    $query2 .= "userID, typeID";
    $query2 .= ") VALUES (";
    $query2 .= $user_id . ",'Seller')";
    $seller_creation = mysqli_query($connection, $query2);

    // all queries must be successful otherwise an error is thrown
    if ($result && $buyer_creation && $seller_creation) {
        // Success
        $_SESSION["message"] = "Welcome {$fName}";
        attempt_login($username, $password);
        // TODO change to user's home page. Need to store user id as well
        redirect_to("auction_list.php");
    } else {
        // Failure
        $message = "Failed to create account. Please try again.";
        //TODO redirect to sign up page and display message
    }


} ?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sign Up Page</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
    <link href="../css/create_auctionStyling.css" rel="stylesheet">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->


</head>

<body style="background-color: #dbdbdb">

<nav class="navbar navbar-gold navbar-fixed-top" role="navigation" style="box-shadow: 0px 0px 10px #606060">
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
            <a href="#"><img class="navbar-brand" src="../images/logo2.png" style="padding: 4px"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-gold-collapse" id="bs-example-navbar-collapse-1">
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
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="loginPage.php">Log in</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<div class="container">
    <div class="col-sm-12">

        <div class="row panel panel-default panel-shadow">
            <div class="col-sm-4" style="padding-top: ">
                <img src="../images/logo2.png" class="img-responsive center-block" style="padding-top: 45px">
            </div>
            <form class="form" action="sign_up.php" method="post">
                <div class="col-sm-4">
                    <h3 class="field-title">First Name</h3>
                    <input class="input-lg" type="text" name="first_name" value="<?php echo htmlentities($fName); ?> "/>
                    <h3 class="field-title">Last Name</h3>
                    <input class="input-lg" type="text" name="last_name" value="<?php echo htmlentities($lName); ?> "/>
                    <h3 class="field-title">Email</h3>
                    <input class="input-lg" type="text" name="email" value="<?php echo htmlentities($userEmail); ?> "/>
                </div>
                <div class="col-sm-4">
                    <h3 class="field-title">Username</h3>
                    <input class="input-lg" type="text" name="username"
                           value="<?php echo htmlentities($userName); ?> "/>
                    <h3 class="field-title">Password</h3>
                    <input class="input-lg" type="password" name="password" value=""/>
                    <h3 class="field-title">Confirm Password</h3>
                    <input class="input-lg" type="password" name="password_confirmation" value=""/><br/><br/>
                </div>
                <div class="col-sm-12" align="center">
                    <button class="btn-gold form-control" type="submit" name="submit" value="Complete Sign Up">Complete Sign Up</button>
                </div>
            </form><!-- all forms include a submit button -->
        </div>
    </div>



<div class="text-danger" align="center">
    <?php echo form_errors(errors()); ?></div>
    <footer>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Team 40 Money Motivation</p>
            </div>
        </div>
        <!-- /.row -->
    </footer>
</div>
</body>

</html>
