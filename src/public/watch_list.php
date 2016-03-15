<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auction Vault</title>

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
<?php require_once("../includes/navbar.php"); ?>

<body>
<!-- Page Content -->
=======
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/general_functions.php"); ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/watch_list_functions.php"); ?>
<?php require_once("../includes/pagination_class.php"); ?>

<?php
// redirect to login page if a valid user is not signed in
if(!attempt_login($_SESSION["username"], $_SESSION["password"])) {
   redirect_to("loginPage.php");
}

?>

<?php
// current page number - set to 1 by default
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// number of auctions to be shown per page
$per_page = 5;

// find ALL auctions watched by user to obtain total count
$watched_auctions = find_users_watched_items($_SESSION["userID"]);

// obtain total number of auctions watched by user
$total_count = mysqli_num_rows($watched_auctions);

$pagination = new Pagination($page, $per_page, $total_count);

// find records for this page
global $connection;
$userID = $_SESSION["userID"];


$query = "SELECT * FROM WatchList w ";
$query .= "JOIN Auction a ";
$query .= "ON w.auctionID = a.auctionID ";
$query .= "JOIN Item i ";
$query .= "ON a.itemID = i.itemID ";
$query .= "WHERE w.userID = {$userID} ";
$query .= "ORDER BY auctionEnd ASC ";
$query .= "LIMIT {$per_page} ";
$query .= "OFFSET {$pagination->offset()}";

$watched_auction_set = mysqli_query($connection, $query);
?>


<!-- header -->
<?php include("../includes/layouts/header.php") ?>
<!--navbar-->
<?php include("../includes/layouts/navbar.php") ?>

<!-- Display list of watched auctions  -->
>>>>>>> develop
<div class="container">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Watchlist</h2>
            <?php echo mysqli_error($connection); ?>


        </div>
    </div>




    <?php


    foreach ($watched_auction_set as $watched_auction) { ?>

        <div class="row">
            <div class="col-md-3">
                <a href="auction_view?auctionID="<?php echo urlencode($watched_auction["auctionID"]); ?>">
                <img class="img-responsive" src="../images/<?php echo $watched_auction["itemPhoto"]; ?>"/>
                </a>
            </div>
            <div class="col-md-6">
                <h3><?php echo htmlentities($watched_auction["itemName"]); ?> </h3>
                <h4><?php echo htmlentities($watched_auction["itemCategory"]); ?></h4>
                <h6><span style="font-weight: bold;">Quantity:&nbsp;</span><?php echo htmlentities($watched_auction["itemQuantity"]); ?></h6>
                <h6><span style="font-weight: bold;">Condition:&nbsp;</span><?php echo htmlentities($watched_auction["itemCondition"]); ?></h6>
                <h6><span style="font-weight: bold;">End Date:&nbsp;</span><?php echo htmlentities($watched_auction["auctionEnd"]); ?></h6>
                <p><?php echo htmlentities($watched_auction["itemDescription"]) ?></p>
            </div>
            <div class="col-md-3">
                <a  class="btn btn-primary"
                   href=auction_view.php?auctionID="<?php echo urlencode($watched_auction["auctionID"]); ?>">View More</a>
                <a  class="btn btn-primary" href="delete_watchlist_auction.php?watchID=<?php echo htmlentities($watched_auction["watchID"]); ?>">Remove</a>
            </div>
        </div>
        <br /><br />

        <?php
    } // end of loop through watched_auction result set

    ?>

    <div id="pagination">
        <?php if($pagination->total_pages() > 1) {
            // display button to go back to previous page if it exists
            if($pagination->has_previous_page()) {
                echo " <a href=\"watch_list.php?page=";
                echo $pagination->previous_page();
                echo "\">&laquo; Previous</a> ";
            }

            for($i = 1; $i <= $pagination->total_pages(); $i++) {
                if($i == $page) {
                    echo " <span class=\"selected\">{$i}</span> ";
                } else {
                    echo " <a href=\"watch_list.php?page={$i}\">{$i}</a>";
                }

            }

            // display button to go to next page if it exists
            if($pagination->has_next_page()) {
                echo " <a href=\"watch_list.php?page=";
                echo $pagination->next_page();
                echo "\">Next &raquo;</a> ";
            }

        } ?>



    </div>


    <!-- Footer -->
    <?php include("../includes/layouts/footer.php") ?>
