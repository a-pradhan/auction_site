<?php
require_once("../includes/session.php");
require_once("../includes/general_functions.php");
require_once("../includes/watch_list_functions.php");

echo "watch auction page";
$auctionID = $_GET['auction'];
$userID = $_SESSION['userID'];
$itemID = $_GET['item'];

// check that auctionID and userID are available
if (isset($auctionID) && isset($userID)) {
    if (is_auction_in_watchlist($userID, $auctionID)) {
        // auction NOT added to watchlist
        $_SESSION['watch_list_message'] = "You are already watching this auction";
        redirect_to("auction_view.php?auction={$itemID}");
    } else {
        // ADD auction to watchlist
        add_auction_to_watchlist($_SESSION['userID'], $_GET['auction']);
        $_SESSION['watch_list_message'] = "Auction was added to your Watch List.";
        // redirect back to the previous auction page.
        redirect_to("auction_view.php?auction={$itemID}");
    }
} else {
    // auction id and/or userID not set in $_GET/$_SESSION
    $_SESSION['error'] = "Could not save auction to your Watch List. Please try again.";
    redirect_to("auction_list.php");
}


?>

