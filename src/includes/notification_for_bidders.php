<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/user.php"); ?>

<?php
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$loggedIn_userID = $_SESSION["admin_id"];
?>


<?php
$outbid_or_successful =0;
$my_bids_buyerID = retrieve_buyerID_from_loggedIn_userID($loggedIn_userID);
$all_my_bids = retrieve_my_bids ($my_bids_buyerID);

$counter=0;
while ($my_bids = mysqli_fetch_assoc($all_my_bids)){


$my_latest_bidAmount = "£ " . $my_bids['MAX( bidAmount )'];



$auction_bidded_on_set = retrieve_my_auctions_for_a_given_auctionID ($my_bids['auctionID']);


    while ($auction_bidded_on = mysqli_fetch_assoc($auction_bidded_on_set)){

    $bid_amount_set = mysqli_fetch_assoc(find_bidAmount_for_bidID($auction_bidded_on['bidID']));

    $auction_highest_bid = "£ " . $bid_amount_set['bidAmount'];


    $my_auction_latest_bidID = $auction_bidded_on['bidID'];

    $bid_amount_set = mysqli_fetch_assoc(find_bidAmount_for_bidID($my_auction_latest_bidID));
    $my_auction_latest_bidAmount = "£ " . $bid_amount_set['bidAmount'];


    $auction_successful = $auction_bidded_on["auctionSuccessful"];
    $auctionID =$auction_bidded_on['auctionID'];

    if (($auction_successful == 1 && ($my_latest_bidAmount >= $my_auction_latest_bidAmount)) || ($my_latest_bidAmount < $my_auction_latest_bidAmount || ($auction_bidded_on['auctionLive'] == 0))) {
        $outbid_or_successful = 1;

        } else {
        $outbid_or_successful = 0;
        }
    }


    }

?>



