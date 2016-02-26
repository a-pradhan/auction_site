<?php
session_destroy();
session_start();
//$username = $_SESSION['userNameSess'];
//echo $username;
//if(isset($_SESSION['userNameSess'])&& isset($_SESSION['passwordSess'])){
//    header('Location: index.php');
//}
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Start Bootstrap</a>
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
<form class="form" action="auction_list.php" method="post">
    <h3 class="text-primary">Username:</h3>
    <input class="input-lg" type="text" name="userNameForm" placeholder="Username"><br>
    <h3 class="text-primary">Password:</h3>
    <input class="input-lg" type="password" name="passwordForm" placeholder="Password"><br><br>
    <input class="btn btn-warning btn-lg" type="submit" value="Log in">
    <a href="loginPage.php" class="bg-warning btn -lg" type="submit">refresh</a>
</form><!-- all forms include a submit button -->

</div>
</br>
<div class="text-danger" align="center"> <?php
   echo $_SESSION['loginError'];
    $_SESSION['loginError'] = '';
    ?> </div>
</body>

</html>
