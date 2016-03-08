<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/watch_list_functions.php"); ?>

<!-- header -->
<?php include("../includes/layouts/header.php") ?>

<!--navbar-->
<?php include("../includes/layouts/navbar.php") ?>

<!-- Display list of watched auctions  -->
<div class="container">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Watchlist</h2>


        </div>
    </div>
    <?php $watched_auction_set = find_users_watched_items(1004);

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
                <a style="float: right;" class="btn btn-primary" href="delete_watchlist_auction.php?watchID=<?php echo htmlentities($watched_auction["watchID"]); ?>">Delete From Watchlist</a>
            </div>
        </div>
        <br />

        <?php
    } // end of loop through watched_auction result set

    ?>


    <!-- Footer -->
    <?php include("../includes/layouts/footer.php") ?>
