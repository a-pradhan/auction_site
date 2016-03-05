<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/auction_functions.php"); ?>
<?php require_once("../includes/validate_live_auctions.php"); ?>
<?php require_once("../includes/awardSuccessful_auctions.php"); ?>


<?php

//Commen
    $username = $_SESSION["username"];


    $password = $_SESSION["password"];

    $loggedIn_userID = $_SESSION["admin_id"];

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
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
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

                <button type="button" class="pull-right" onclick="location.href = 'loginPage.php';">Log Out</button>
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
        <div class="col-md-12">
            <h2 class="page-header">Live auctions
                <small>Money motivation</small>
            </h2>
        </div>
    </div>
    <!-- Search and filtering -->
    <div class="row">
        <div class="col-md-6">

            <form action="auction_list.php" method="POST">
                Category
                <select name="category">
                    <option value=""></option>
                    <option value="Car">Car</option>
                    <option value="Mobile Phone">Mobile Phones</option>
                    <option value="Laptop">Laptops</option>
                    <option value="Jewellry">Jewellry</option>
                    <option value="Miscellaneous">Miscellaneous</option>
                </select>
                Condition
                <select name="condition">
                    <option value=""></option>
                    <option value="Used">Used</option>
                    <option value="Used - Like New">Used - Like New</option>
                    <option value="New">New</option>
                </select>
                Sort by
                <select name="sortBy">
                    <option value=""></option>
                    <option value="Price">Price</option>
                    <option value="Time">Time</option>
                </select>
                <input id="refine" name="refine" type="submit" value="Refine">
            </form>


        </div>
        <form action="auction_list.php" method="POST">
            <input id="search" name="searchField" type="text" style="width: 500px;"
                   placeholder="Search by name, description or category of item!">
            <input id="submit" type="submit" value="Search">
        </form>
    </div>


    <?php
    // Retrieve all live auctions (auctionLive =1)
    $live_auctions = find_all_live_auctions();


    ?>

    <!-- Check for search and filtering and then display auctions accordingly --->

    <?php
    if (isset($_POST['refine'])) {

        // Checks if two filter factors have been chosen
        if (($_POST["category"] != "") && ($_POST["condition"] != "")) {
            $refined_category = $_POST["category"];

            $refined_condition = $_POST["condition"];
            $live_auctions = refined_live_auctions($refined_category, $refined_condition);
        }

        //Checks if only the category factor has been chosen
        if ($_POST["category"] != "" && $_POST["condition"] == "") {
            $refined_category = $_POST["category"];
            $live_auctions = refined_live_auctions($refined_category, false);

        }
        //Checks if only the condition factor has been chosen
        if ($_POST["condition"] != "" && $_POST["category"] == "") {
            $refined_condition = $_POST["condition"];
            $live_auctions = refined_live_auctions(false, $refined_condition);
        }

        //To be implemented, sort by the most recent or cheapest price
        if ($_POST["sortBy"] != "") {

        }
    }

    if (isset($_POST['searchField'])) {
        //Retrieve the text inserted into the search field
        $search_string_identified = mysqli_real_escape_string($connection, $_POST["searchField"]);
        //Break the string up into an array
        $auction_search_array = explode (" ", $search_string_identified);
        //Call the function to retrieve the set of results from the search
        $search_auction_set = search_live_auctions($auction_search_array);

        //Detect unsuccessful searches
        if (mysqli_num_rows($search_auction_set) == 0) {
            echo "Sorry, no auctions found. Try filtering!";
        }

        $live_auctions = $search_auction_set;
    }



    // while loop to fetch each row of auction one by one
            while ($auction = mysqli_fetch_assoc($live_auctions)) {

                // Retrieving the itemID for each row of auction
                $live_itemID = $auction["itemID"];

                // Retrieving the row for the auction item from Item table
                $live_item_info = mysqli_fetch_assoc(find_item_for_live_auction($live_itemID));
                //$live_item_info = mysqli_fetch_assoc($item_info);
                echo "Live! <br>";
                echo "<div class=\"row\">";
                echo "<div class=\"col-md-3\">";
                echo "<a href=\"#\">";
                echo "<img class=\"img-responsive\" src=\"../images/" . $live_item_info["itemPhoto"] . "\" alt=\"\">";
                echo "</a>";
                echo "</div>";
                echo "<div class=\"col-md-6\">";
                echo "<h3>" . htmlentities($live_item_info["itemName"]) . "</h3>";
                echo "<h4>" . htmlentities($live_item_info["itemCategory"]) . "</h4>";
                echo "<h6><span style=\"font-weight:bold\">" . "Quantity: </span>" . htmlentities($live_item_info["itemQuantity"]) . "" . "<span style=\"color:#880000 ;text-align:center;float: right\">Reserve price at £" . htmlentities($auction["auctionReservePrice"]) . "</span></h6>";
                echo "<h6><span style=\"font-weight:bold\">" . "Condition: </span>" . htmlentities($live_item_info["itemCondition"]) . "</h6>";
                echo "<p>" . htmlentities($live_item_info["itemDescription"]) . "</p>";
                echo "<a style= \"float:right;\"  class=\"btn btn-primary\" href=\"auction_view.php?auction=" . urlencode($live_item_info["itemID"]) . "\" >View More<span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
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
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>

</html>
