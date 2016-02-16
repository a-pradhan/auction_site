<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php") ?>


<?php
    $live_auctions = find_all_live_auctions();
?>

<html lang="en">
<head>
    <title>Auction Vault</title>
</head>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>1 Col Portfolio - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

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

<!-- Navigation -->
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
            <a class="navbar-brand" href="#">Auction Vault</a>
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

<!-- Page Content -->
<div class="container">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Live auctions
                <small>Money motivation</small>
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <?php

    while($auction=mysqli_fetch_assoc($live_auctions)) {
        $live_itemID = $auction["itemID"];
        $item_info = find_item_for_live_auction($live_itemID);
        $live_item_info = mysqli_fetch_assoc($item_info);
        echo "Live! <br>";
        echo "<div class=\"row\">";
        echo "<div class=\"col-md-3\">";
        echo    "<a href=\"#\">";
        echo        "<img class=\"img-responsive\" src=\"../images/" . $live_item_info["itemPhoto"] ."\" alt=\"\">";
        echo    "</a>";
        echo "</div>";
        echo "<div class=\"col-md-6\">";
        echo    "<h3>" .  htmlentities($live_item_info["itemName"]) ."</h3>";
        echo    "<h4>" . htmlentities($live_item_info["itemCategory"]) ."</h4>";
        echo    "<h5>" . "Quantity: " .htmlentities($live_item_info["itemQuantity"]) . "". "<span style=\"color:#880000 ;text-align:center;float: right\">Reserve price at £". htmlentities($auction["auctionReservePrice"]) . "</span></h5>";
        echo    "<p>" . htmlentities($live_item_info["itemDescription"]) . "</p>";
        echo   "<a style= \"float:right;\"  class=\"btn btn-primary\" href=\"#\">View More<span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
        echo "</div>";
        echo "</div>";
        echo "<hr>";
    }
    ?>

    <!-- Pagination -->
    <div class="row text-center">
        <div class="col-lg-12">
            <ul class="pagination">
                <li>
                    <a href="#">&laquo;</a>
                </li>
                <li class="active">
                    <a href="#">1</a>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#">3</a>
                </li>
                <li>
                    <a href="#">4</a>
                </li>
                <li>
                    <a href="#">5</a>
                </li>
                <li>
                    <a href="#">&raquo;</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Team 40 Money Motivation</p>
            </div>
        </div>
        <!-- /.row -->
    </footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
</html>

/**
 * Created by PhpStorm.
 * User: sadiq
 * Date: 10/02/16
 * Time: 20:11
 */