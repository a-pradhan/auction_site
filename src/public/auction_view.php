<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/auction_functions.php"); ?>
<?php require_once("../includes/validate_live_auctions.php"); ?>
<?php require_once("../includes/awardSuccessful_auctions.php"); ?>


<?php
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $loggedIn_userID = $_SESSION["userID"];
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auction Details</title>


    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/create_auctionStyling.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/shop-item.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.countdown.js"></script>
    <script src="../js/jquery.countdown.min.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body style="background-color: #dbdbdb">


<!-- Navigation -->
<?php include("../includes/layouts/navbar.php") ?>

<!-- Page Content -->
<?php
    if(isset($_SESSION['watch_list_message'])) { ?>
        <div class="col-sm-12" align="center">
       <h6 class ="rd" style="font-size: 18px;"> <?php echo $_SESSION['watch_list_message']; ?></h6>
            </div>
<?php
        unset($_SESSION['watch_list_message']);
    }
    // Retrieve the itemID for the auction selected
    $chosen_auction_item = $_GET["auction"];
    // Retrieve the auction row for the auction selected using the itemID

    $chosen_auction_info = mysqli_fetch_assoc(find_auction_for_chosen_item($chosen_auction_item));
    $chosen_auction_ID = $chosen_auction_info['auctionID'];

    //This will increment the viewing
    $viewing_set = mysqli_fetch_assoc(retrieve_viewing_for_chosen_auction($chosen_auction_ID));
    $updated_viewing = intval($viewing_set["auctionViewings"]);
    $updated_viewing++;
    update_viewing_for_chosen_auction ($chosen_auction_ID,$updated_viewing);

    // Fetch the item info from Item table using the itemID
    $chosen_item_info = find_item_for_live_auction($chosen_auction_item);
    $chosen_live_item_info = mysqli_fetch_assoc($chosen_item_info);


    //The following is to prevent an owner of an auction to bid on their own auction
    $my_auctions_sellerID = retrieve_sellerID_from_loggedIn_userID($loggedIn_userID);

    $all_my_auctions = retrieve_my_auctions ($my_auctions_sellerID);
    $can_I_bid =1;
    while ($my_auctions_for_checking = mysqli_fetch_assoc($all_my_auctions)) {
        if ($my_auctions_for_checking["auctionID"] == $chosen_auction_ID ) {
            $can_I_bid = 0;
        }
    }
  // debugging


?>


<div class="container">

    <div class="col-sm-12">
        <h1 class="page-title">Auction Details</h1>
        <hr>
        <div class="row panel panel-default panel-shadow">
            <div class="col-md-5">
            <div class="thumbnail" style="border: none">
                <?php //retrieves the name of the photo to be shown ?>
                <img class="img-responsive" src="../itemImages/<?php echo $chosen_live_item_info["itemPhoto"] ?>" onerror="this.src='../images/logo2.png'">
            </div>
        </div>

        <div class="col-md-7">
            <div class="ratings">
                <?php // A POST to store the itemID in the url ?>
                <form id="bidAmount" action="auction_view.php?auction=<?php echo $chosen_auction_item ?>" method="POST"
                      style=float:right;>
                    <input type="number" id="bidField" name="bidField" placeholder="Enter bid here!">
                    <input type="submit" id ="oneBid" name="bid" value="Bid" onclick="myFunction()">
                </form>

               <?php // JS code for retrieving the bidAmount from the bidField ?>
                <script>

                    $(document).ready(function() {
                        $('input[type="submit"]').prop('disabled', true);
                        $('input[type="number"]').keyup(function() {
                            if($(this).val() != '') {
                                $('input[type="submit"]').prop('disabled', false);
                            }
                        });
                    })

                    var canIBid = <?php echo json_encode($can_I_bid); ?>;

                    function myFunction() {
                        if (canIBid == "0") {
                            alert("You may not bid on your own auction.");
                        } else {

                            var bidAmount = $("#bidField").val();
                            if (bidAmount != '') {
                                confirm("Please confirm - bid amount: £" + bidAmount);
                            } else {
                                alert("Field must not be empty, please enter a bid.");

                            }
                        }
                    }


                </script>




                <?php
                //Code for verifying the bidAmount and essential validations
                if (isset($_POST['bid'])) {

                    $auctionLive_status = confirm_auction_is_live ($chosen_auction_ID);

                    if ($auctionLive_status == 0) {
                        redirect_to("auction_list.php");
                    }
                    else {
                        if ($can_I_bid == 0) {

                            //the bid would not be posted

                        } else {


                            global $connection;

                            $new_bid_amount = mysqli_real_escape_string($connection, $_POST['bidField']);
                            if ($new_bid_amount == null) {
                            } else {

                                if ($chosen_auction_info['bidID'] == null) {
                                    //The first ever bid for an auction

                                    bid_an_amount($chosen_auction_ID, $new_bid_amount, $loggedIn_userID);
                                    $bidID_for_recent_bid = mysqli_fetch_assoc(retrieve_bidID_for_recent_bid($chosen_auction_ID, $new_bid_amount));
                                    $bidID = $bidID_for_recent_bid['bidID'];
                                    update_bid_on_auction($chosen_auction_ID, $bidID);






                                    //an email to the seller here
                                    $sellerID_set = mysqli_fetch_assoc(retrieve_seller_roleID_from_specified_auctionID($chosen_auction_info['auctionID']));
                                    $seller_roleID = $sellerID_set['roleID'];
                                    $sellerOutbid_set= mysqli_fetch_assoc(find_userEmail_and_userName_for_bidder($seller_roleID));
                                    $sellerUserName= $sellerOutbid_set['userName'];
                                    $sellerEmail = $sellerOutbid_set['userEmail'];
                                    $auctionName = $chosen_live_item_info["itemName"];
                                    $latestBidAmount = $new_bid_amount;
                                    $auctionExpiry_to_be_formatted =$chosen_auction_info["auctionEnd"];
                                    $time = strtotime($auctionExpiry_to_be_formatted);
                                    $newformat = date('D, d F \a\t H:i',$time);
                                    $auctionExpiry = "" . $newformat;
                                    $auctionViewings=$chosen_auction_info['auctionViewings'];
                                    $bid_set_for_given_auction = retrieve_number_of_bids_for_a_given_auction($chosen_auction_info["auctionID"]);
                                    $number_of_bids = mysqli_fetch_assoc($bid_set_for_given_auction);
                                    $auctionBids= $number_of_bids["COUNT(bidID)"];
                                    ?>
                                    <script>
                                        var sellerUserName = <?php echo json_encode($sellerUserName) ?>;
                                        var sellerEmail = <?php echo json_encode($sellerEmail) ?>;
                                        var auctionName = <?php echo json_encode($auctionName) ?>;
                                        var latestBidAmount = <?php echo json_encode($latestBidAmount) ?>;
                                        var auctionExpiry = <?php echo json_encode($auctionExpiry) ?>;
                                        var auctionViewings=<?php echo json_encode($auctionViewings) ?>;
                                        var auctionBids = <?php echo json_encode($auctionBids) ?>;

                                        function send_seller(){
                                            $.post(
                                                "../includes/seller_email.php",
                                                {   sellerUserName_ajax:  sellerUserName,
                                                    sellerEmail_ajax: sellerEmail,
                                                    auctionName_ajax: auctionName,
                                                    latestBidAmount_ajax: latestBidAmount,
                                                    auctionExpiry_ajax: auctionExpiry,
                                                    auctionViewings_ajax: auctionViewings,
                                                    auctionBids_ajax: auctionBids},
                                                function(data) {

                                                }
                                            );
                                        }
                                    </script>

                                <?php

                                echo "<script>send_seller();</script>";

                                //an email to the watcher here

                                ?>
                                    <script>
                                        var auctionID = <?php echo json_encode($chosen_auction_info['auctionID']) ?>;
                                        var auctionName = <?php echo json_encode($auctionName) ?>;
                                        var latestBidAmount = <?php echo json_encode($latestBidAmount) ?>;
                                        var auctionExpiry = <?php echo json_encode($auctionExpiry) ?>;
                                        var auctionBids = <?php echo json_encode($auctionBids) ?>;

                                        function send_watcher(){
                                            $.post(
                                                "../includes/watcher_email.php",
                                                {   auctionID_ajax:  auctionID,
                                                    auctionName_ajax: auctionName,
                                                    latestBidAmount_ajax: latestBidAmount,
                                                    auctionExpiry_ajax: auctionExpiry,
                                                    auctionBids_ajax: auctionBids},
                                                function(data) {

                                                }
                                            );
                                        }


                                    </script>

                                <?php
                                echo "<script>send_watcher();</script>";

                                } else {

                                //retrieving the old bidder roleID
                                $previous_bidID = $chosen_auction_info['bidID'];
                                $bid_amount_set = mysqli_fetch_assoc(find_bidAmount_for_bidID($previous_bidID));
                                $previous_bid_amount = $bid_amount_set['bidAmount'];

                                if ($new_bid_amount > $previous_bid_amount) {

                                $previous_buyer_roleID_set =mysqli_fetch_assoc(retrieve_buyer_roleID_from_specified_auctionID($chosen_auction_ID));
                                $previous_bidder_roleID = $previous_buyer_roleID_set['roleID'];

                                bid_an_amount($chosen_auction_ID, $new_bid_amount, $loggedIn_userID);

                                $bidID_for_recent_bid = mysqli_fetch_assoc(retrieve_bidID_for_recent_bid($chosen_auction_ID, $new_bid_amount));
                                $bidID = $bidID_for_recent_bid['bidID'];
                                update_bid_on_auction($chosen_auction_ID, $bidID);



                                //an email to the seller here
                                $sellerID_set = mysqli_fetch_assoc(retrieve_seller_roleID_from_specified_auctionID($chosen_auction_info['auctionID']));
                                $seller_roleID = $sellerID_set['roleID'];
                                $sellerOutbid_set= mysqli_fetch_assoc(find_userEmail_and_userName_for_bidder($seller_roleID));
                                $sellerUserName= $sellerOutbid_set['userName'];
                                $sellerEmail = $sellerOutbid_set['userEmail'];
                                $auctionName = $chosen_live_item_info["itemName"];
                                $latestBidAmount = $new_bid_amount;
                                $auctionExpiry_to_be_formatted =$chosen_auction_info["auctionEnd"];
                                $time = strtotime($auctionExpiry_to_be_formatted);
                                $newformat = date('D, d F \a\t H:i',$time);
                                $auctionExpiry = "" . $newformat;
                                $auctionViewings=$chosen_auction_info['auctionViewings'];
                                $bid_set_for_given_auction = retrieve_number_of_bids_for_a_given_auction($chosen_auction_info["auctionID"]);
                                $number_of_bids = mysqli_fetch_assoc($bid_set_for_given_auction);
                                $auctionBids= $number_of_bids["COUNT(bidID)"];



                                ?>
                                    <script>
                                        var sellerUserName = <?php echo json_encode($sellerUserName) ?>;
                                        var sellerEmail = <?php echo json_encode($sellerEmail) ?>;
                                        var auctionName = <?php echo json_encode($auctionName) ?>;
                                        var latestBidAmount = <?php echo json_encode($latestBidAmount) ?>;
                                        var auctionExpiry = <?php echo json_encode($auctionExpiry) ?>;
                                        var auctionViewings=<?php echo json_encode($auctionViewings) ?>;
                                        var auctionBids = <?php echo json_encode($auctionBids) ?>;

                                        function send_seller(){
                                            $.post(
                                                "../includes/seller_email.php",
                                                {   sellerUserName_ajax:  sellerUserName,
                                                    sellerEmail_ajax: sellerEmail,
                                                    auctionName_ajax: auctionName,
                                                    latestBidAmount_ajax: latestBidAmount,
                                                    auctionExpiry_ajax: auctionExpiry,
                                                    auctionViewings_ajax: auctionViewings,
                                                    auctionBids_ajax: auctionBids},
                                                function(data) {

                                                }
                                            );
                                        }
                                    </script>

                                <?php

                                echo "<script>send_seller();</script>";


                                //an email to the bidder outbid
                                $auctionName = $chosen_live_item_info["itemName"];
                                $latestBidAmount = $new_bid_amount;
                                $userOutbid_set= mysqli_fetch_assoc(find_userEmail_and_userName_for_bidder($previous_bidder_roleID));
                                $bidderUserName= $userOutbid_set['userName'];
                                $bidderEmail = $userOutbid_set['userEmail'];
                                $auctionExpiry_to_be_formatted =$chosen_auction_info["auctionEnd"];
                                $time = strtotime($auctionExpiry_to_be_formatted);
                                $newformat = date('D, d F \a\t H:i',$time);
                                $auctionExpiry = "" . $newformat;


                                ?>


                                    <script>
                                        var bidderUserName = <?php echo json_encode($bidderUserName) ?>;
                                        var bidderEmail = <?php echo json_encode($bidderEmail) ?>;
                                        var auctionName = <?php echo json_encode($auctionName) ?>;
                                        var latestBidAmount = <?php echo json_encode($latestBidAmount) ?>;
                                        var auctionExpiry = <?php echo json_encode($auctionExpiry) ?>;
                                        function send_outbid(){
                                            $.post(
                                                "../includes/outbid_email.php",
                                                {   bidderUserName_ajax:  bidderUserName,
                                                    bidderEmail_ajax: bidderEmail,
                                                    auctionName_ajax: auctionName,
                                                    latestBidAmount_ajax: latestBidAmount,
                                                    auctionExpiry_ajax: auctionExpiry},
                                                function(data) {

                                                }
                                            );
                                        }
                                    </script>

                                <?php

                                echo "<script>send_outbid();</script>";







                                //an email to the watcher
                                ?>
                                    <script>
                                        var auctionID = <?php echo json_encode($chosen_auction_info['auctionID']) ?>;
                                        var auctionName = <?php echo json_encode($auctionName) ?>;
                                        var latestBidAmount = <?php echo json_encode($latestBidAmount) ?>;
                                        var auctionExpiry = <?php echo json_encode($auctionExpiry) ?>;
                                        var auctionBids = <?php echo json_encode($auctionBids) ?>;

                                        function send_watcher(){
                                            $.post(
                                                "../includes/watcher_email.php",
                                                {   auctionID_ajax:  auctionID,
                                                    auctionName_ajax: auctionName,
                                                    latestBidAmount_ajax: latestBidAmount,
                                                    auctionExpiry_ajax: auctionExpiry,
                                                    auctionBids_ajax: auctionBids},
                                                function(data) {

                                                }
                                            );
                                        }


                                    </script>

                                    <?php
                                    echo "<script>send_watcher();</script>";



                                    echo "Bid successful!";
                                } else {
                                    //new bid amount is too low, must be higher than previous amount!
                                    echo "Your bid must be higher than the latest bidder!";
                                }
                                }

                            }
                        }
                    }
                }
                ?>



                <?php

                $roleID_set = mysqli_fetch_assoc(retrieve_seller_roleID_from_specified_auctionID($chosen_auction_ID));

                $roleID=$roleID_set['roleID'];
                $rating_set=retrieve_rating_for_specified_role($roleID);
                $rating_for_role = mysqli_fetch_assoc($rating_set);
                $rating_score = intval($rating_for_role['AVG(ratingValue)']);
                $whole_number_rating_score = round($rating_score);
                $empty_stars= 5 - $whole_number_rating_score;

                ?>

                <p style="font-size:160%;"> Seller's ratings

                    <?php

                    for($x=0;$x<$whole_number_rating_score;$x++){
                        echo "<span class=\"glyphicon glyphicon-star\"></span>";
                    }
                    for($z=0;$z<$empty_stars;$z++){
                        echo "<span class=\"glyphicon glyphicon-star-empty\"></span>";
                    }

                    ?>


            </div>


        </div>
        <?php
        //code for the timerCount down
        $auction_end_time = $chosen_auction_info["auctionEnd"];
        ?>

        <div class="col-md-7">


            <div class="thumbnail" style="border: groove">
                <div class="caption-full">
                    <h4 class="pull-right" style="color:#880000">Reserve price at
                        £ <?php echo htmlentities($chosen_auction_info["auctionReservePrice"]); ?></h4>

                    <h4><?php echo htmlentities($chosen_live_item_info["itemName"]); ?></h4>
                    <h6 class="pull-right" style="color:#880000">Time left ~
                        <div class="pull-right" id="clock"></div>
                    </h6>

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

                        var t = <?php echo json_encode($auction_end_time); ?>;

                        var d = Date.createFromMysql(t);

                        $('#clock').countdown(d, function (event) {
                            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                            $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
                        });
                    </script>


                    <p><strong>Category: </strong><?php echo htmlentities($chosen_live_item_info["itemCategory"]); ?></p>

                    <p><strong>
                            Quantity:</strong><?php echo " " . htmlentities($chosen_live_item_info["itemQuantity"]); ?>
                    </p>

                    <!-- TODO change auction to itemID for the auction_view page to avoid confusion as it currently represents the itemID not the auctionID   -->
                    <a style="float: right;" class="btn btn-gold" href="watch_auction.php?auction=<?php echo urlencode($chosen_auction_ID);
                    ?>&item=<?php echo urlencode($_GET['auction']); ?>">Add to Watch List</a>

                    <p><strong>
                            Condition:</strong><?php echo " " . htmlentities($chosen_live_item_info["itemCondition"]); ?>
                    </p>
                    <p>
                        <strong>Description:</strong><?php echo " " . htmlentities($chosen_live_item_info["itemDescription"]); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <?php
            echo "<div class=\"thumbnail\" style='border: groove'>";
            echo "<p class=\"field-title\" style='font-size: 24px;text-align: center'>Latest bidders</p>";
            echo "<div class=\"list-group\ scrollable-list\">";

            $bid_set = find_bids_for_live_auction($chosen_auction_ID);
            if (mysqli_num_rows($bid_set) == 0) {
                echo "Currently no bids!";
            } else {
                $count = 0;
                while ($bids = mysqli_fetch_assoc($bid_set)) {
                    $bidderName = mysqli_fetch_assoc(find_userName_for_bidder($bids['roleID']));

                    $bidder_roleID= $bids['roleID'];
                    $rating_set=retrieve_rating_for_specified_role($bidder_roleID);
                    $rating_for_role = mysqli_fetch_assoc($rating_set);
                    $rating_score = intval($rating_for_role['AVG(ratingValue)']);
                    $whole_number_rating_score = round($rating_score);
                    $empty_stars= 5 - $whole_number_rating_score;


                    if ($count == 0) {
                        echo "<ol class=\"list-group-item btn-gold\">" . htmlentities($bidderName['userName']) . htmlentities(" ~ ") . htmlentities(" ") . htmlentities("£") . htmlentities($bids['bidAmount']);
                    for($x=0;$x<$whole_number_rating_score;$x++){
                        if ($x ==0) {
                            echo "<span style=\"margin-left: 2em;\" class=\"glyphicon glyphicon-star\";></span>";
                        } else {
                        echo "<span class=\"glyphicon glyphicon-star\"></span>";
                        }
                    }
                    for($z=0;$z<$empty_stars;$z++){
                        if ($empty_stars == 5 && $z == 0) {
                            echo "<span style=\"margin-left: 2em;\" class=\"glyphicon glyphicon-star-empty\";></span>";

                        } else {
                            echo "<span class=\"glyphicon glyphicon-star-empty\"></span>";

                        }
                    }
                        echo "</ol>";
                        $count++;
                    } else {

                        echo "<ol class=\"list-group-item\">" . htmlentities($bidderName['userName']) . htmlentities(" ~ ") . htmlentities(" ") . htmlentities("£") . htmlentities($bids['bidAmount']);
                        for($x=0;$x<$whole_number_rating_score;$x++){
                            if ($x ==0) {
                                echo "<span style=\"margin-left: 2em;\" class=\"glyphicon glyphicon-star\";></span>";
                            } else {
                                echo "<span class=\"glyphicon glyphicon-star\"></span>";
                            }
                        }
                        for($z=0;$z<$empty_stars;$z++){
                            if ($empty_stars == 5 && $z == 0) {
                                echo "<span style=\"margin-left: 2em;\" class=\"glyphicon glyphicon-star-empty\";></span>";

                            } else {
                                echo "<span class=\"glyphicon glyphicon-star-empty\"></span>";

                            }
                        }
                        echo "</ol>";
                        $count++;
                    }
                }
            }
            echo "</div>";
            echo "</div>";
            ?>
        </div>
        </div>
    </div>


</div>



<?php global $connection; echo mysqli_error($connection); ?>
<!-- /.container -->

<div class="container">

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Your Website 2014</p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->


<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>


</body>

</html>
