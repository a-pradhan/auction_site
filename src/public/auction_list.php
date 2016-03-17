<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/auction_functions.php"); ?>
<?php require_once("../includes/validate_live_auctions.php"); ?>
<?php require_once("../includes/awardSuccessful_auctions.php"); ?>
<?php require_once("../includes/pagination_class.php"); ?>


<?php
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$loggedIn_userID = $_SESSION["userID"];

if (!isset($loggedIn_userID) && !attempt_login($username, $password)) {
    redirect_to("loginPage.php");
}
?>

<?php require("../includes/layouts/header.php"); ?>
<body style="background-color: #dbdbdb" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

<?php require("../includes/layouts/navbar.php"); ?>
<script src="../js/jquery.js"></script>
<script src="../js/jquery.countdown.js"></script>
<script src="../js/jquery.countdown.min.js"></script>

<!-- Page Content -->
<div class="container">
    <div class="col-sm-12">
        <!-- Page Heading -->

        <!-- Search and filtering -->
        <h1 class="page-title">Live Auctions</h1>
        <hr>

        <div class="col-sm-6" style="padding-bottom: 5px;">

            <form action="auction_list.php" method="POST">
                <div class="col-sm-4" style="padding-bottom: 5px">
                    <div class="field-title" style="font-size: 16px">Category</div>

                    <select name="category" class="form-control">
                        <option value=""></option>
                        <option value="Car">Car</option>
                        <option value="Mobile Phone">Mobile Phones</option>
                        <option value="Laptop">Laptops</option>
                        <option value="Jewellry">Jewellry</option>
                        <option value="Miscellaneous">Miscellaneous</option>
                    </select>
                </div>
                <div class="col-sm-4" style="padding-bottom: 5px">
                    <div class="field-title" style="font-size: 16px">Condition</div>
                    <select name="condition" class="form-control">
                        <option value=""></option>
                        <option value="Used">Used</option>
                        <option value="Used - Like New">Used - Like New</option>
                        <option value="New">New</option>
                    </select>
                </div>
                <div class="col-sm-4" style="padding-bottom: 5px">
                    <div class="field-title" style="font-size: 16px">Sort By</div>
                    <select name="sortBy" class="form-control">
                        <option value=""></option>
                        <option value="auctionReservePrice">Reserve price</option>
                        <option value="auctionEnd">Time remaining</option>
                    </select>
                </div>


                <input id="refine" name="refine" type="submit" value="Refine" class="btn-gold form-control">
            </form>
        </div>

        <div class="col-sm-6" style="padding-bottom: 20px; padding-top: 25px;">
            <form action="auction_list.php" method="POST">
                <input id="search" name="searchField" type="text" class="form-control" "
                placeholder="Search by name, description or category of item!">
                <input class="btn-gold form-control" id="submit" type="submit" value="Search">
            </form>
        </div>
    </div>
<div class="col-sm-12">
    <?php
    // Retrieve all live auctions (auctionLive =1)
    $live_auctions = find_all_live_auctions();

    // initialize pagination variables
    // current page number - set to 1 by default
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

    // number of auctions to be shown per page
    $per_page = 5;

    // obtain total number of live auctions
    $total_count = mysqli_num_rows($live_auctions);

    $pagination = new Pagination($page, $per_page, $total_count);

    ?>

    <!-- Check for search and filtering and then display auctions accordingly --->

    <?php

    // QUERY PROCESSING

    global $connection;
    $query = "SELECT * ";
    $query .= "FROM Auction ";
    $query .= "JOIN Item ON Auction.itemID = Item.itemID ";
    $query .= "WHERE Auction.auctionLive = 1 ";

    if (isset($_POST['refine'])) {

        // Checks if category filter has been chosen and appends to query
        if (($_POST["category"] != "")) {
            $query .= "AND Item.itemCategory = " . "'" . mysql_prep($_POST["category"]) . "'";

        }

        // checks if condition filter has been chosen and appends to query
        if (($_POST["condition"] != "")) {
            $query .= " AND Item.itemCondition = " . "'" . mysql_prep($_POST["condition"]) . "'";
        }


        //To be implemented, sort by the most recent or cheapest price
        if ($_POST["sortBy"] != "") {
            $sortPreference = $_POST['sortBy'];
            $query .= "ORDER BY {$sortPreference} ASC ";

        }
    }

    if (isset($_POST['searchField'])) {
        //Retrieve the text inserted into the search field
        $search_string_identified = mysql_prep($_POST["searchField"]);

        //Break the string up into an array
        $auction_search_array = explode(" ", $search_string_identified);

        foreach ($auction_search_array as $search_query) {
            $query .= "AND ( Item.itemCategory LIKE " . "'%" . $search_query . "%' ";
            $query .= "OR Item.itemName LIKE " . "'%" . $search_query . "%' ";
            $query .= "OR Item.itemDescription LIKE " . "'%" . $search_query . "%' )";
        }
    }

    //$query .= " ORDER BY Auction.auctionEnd ASC ";
    $query .= "LIMIT {$per_page} ";
    $query .= "OFFSET {$pagination->offset()}";


    // find records for this page, rows includes auction and relevant item data
    $auction_set = mysqli_query($connection, $query);

    //Detect unsuccessful searches or if there are no live auctions
    if (mysqli_num_rows($auction_set) == 0) {
        echo "Sorry, no auctions found. Try filtering!";
    }

    // while loop to fetch each row of auction one by one
    $counter=0;
    foreach ($auction_set as $auction) {

        // Retrieving the itemID for each row of auction
        // $live_itemID = $auction["itemID"];

        // Retrieving the row for the auction item from Item table
        // $live_item_info = mysqli_fetch_assoc(find_item_for_live_auction($live_itemID));
        //$live_item_info = mysqli_fetch_assoc($item_info);


        echo "<div class=\"row panel panel-default panel-shadow\">";
        echo "Live! <br>";
        echo "<div class=\"row\">";
        echo "<div class=\"col-md-3\">";

        //echo "<a href=\"#\">";
        //echo "<img class=\"img-responsive\" src=\"../itemImages/" . $live_item_info["itemPhoto"] . " onerror=\"this.src=\'../images/logo2.png\' \">" ; ?>
        <img class="img-responsive"
             src="../itemImages/<?php echo $auction["itemPhoto"]; ?>" onerror="this.src='../images/logo2.png'"/>
        <?php
        //echo "</a>";
        echo "</div>";
        echo "<div class=\"col-md-6\">";
        echo "<h3>" . htmlentities($auction["itemName"]) . "</h3>" . "<h4><span style=\"color:#880000 ; \">Reserve price at £" . htmlentities($auction["auctionReservePrice"]) . "</span></h5>";

        echo "<h5> <span style=\"font-weight:bold\">" . "Category: </span>" . htmlentities($auction["itemCategory"]) . "</h5>";
        echo "<h5><span style=\"font-weight:bold\">" . "Quantity: </span>" . htmlentities($auction["itemQuantity"]) . "</span></h5>";
        echo "<h6 class=\"pull-right\" style=\"color:#880000\">Time left ~ " . "\t";
        echo                "<div class=\"pull-right\" id=\"" . "{$counter}" . "\"></div>";
        echo            "</h6>";
        echo "<h5><span style=\"font-weight:bold\">" . "Condition: </span>" . htmlentities($auction["itemCondition"]) . "</h5>";
        echo "<h5><span style=\"font-weight:bold\">" . "Description: </span>" . "</h5>" . "<p>" . htmlentities($auction["itemDescription"]) . "</p>";

        echo "</div>";
        echo "<div class=\"col-md-3\">";
        echo "<div class=\"row\">";

        echo "<a style= \"float:right;\" id=\"countButton\" class=\"btn btn-black\" href=\"auction_view.php?auction=" . urlencode($auction["itemID"]) . "\" >View More<span class=\"glyphicon glyphicon-chevron-right\"></span></a>";

        echo "</div>";

        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<hr>";

        $counter++;


    }

    $counter=0;
    foreach ($auction_set as $auction) {


        ?>
        <script>
            //hilios.github.io/jQuery.countdown/ - reference for the timer
            Date.createFromMysql = function (mysql_string) {
                var t, result = null;

                if (typeof mysql_string === 'string') {
                    t = mysql_string.split(/[- :]/);

                    //when t[3], t[4] and t[5] are missing they defaults to zero
                    result = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
                }

                return result;
            }

        var <?php echo "t{$counter}"; ?> = <?php echo json_encode($auction["auctionEnd"]); ?>;

        var <?php echo "d{$counter}"; ?> =
        Date.createFromMysql(<?php echo "t{$counter}"; ?>);

        <?php $div_counter = "clock{$counter}"; ?>


        $(<?php echo "'#" . "{$counter}" . "'"; ?>).countdown(<?php echo "d{$counter}"; ?>, function (event) {
            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
            $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
        });
    </script>

    <?php

    $counter++;
    }

    ?>
    <!-- Refer to class pagination in CSS for original styling-->
    <div class="row">
        <div id="pagination" class=" col-lg-6 col-sm-offset-6">
            <?php if ($pagination->total_pages() > 1) {
                // display button to go back to previous page if it exists
                if ($pagination->has_previous_page()) {
                    echo " <a href=\"auction_list.php?page=";
                    echo $pagination->previous_page();
                    echo "\">&laquo; Previous</a> ";
                }

                for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                    if ($i == $page) {
                        echo " <span class=\"selected\">{$i}</span> ";
                    } else {
                        echo " <a href=\"auction_list.php?page={$i}\">{$i}</a>";
                    }

                }

                // display button to go to next page if it exists
                if ($pagination->has_next_page()) {
                    echo " <a href=\"auction_list.php?page=";
                    echo $pagination->next_page();
                    echo "\">Next &raquo;</a> ";
                }

            } ?>
        </div>
    </div>

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Team 40 Money Motivation</p>
            </div>
        </div>
        <!-- /.row -->
    </footer><!-- /.container -->
</div>
</div>

<!-- Pagination -->

<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>

</html>
