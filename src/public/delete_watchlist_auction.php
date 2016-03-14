<?php
require_once("../includes/session.php");
require_once("../includes/general_functions.php");
require_once("../includes/watch_list_functions.php");
require_once("../includes/user.php");

// check user is logged in with valid details
if (attempt_login($_SESSION["username"], $_SESSION["password"])) {

    // check watchID is present
    if (isset($_GET["watchID"])) {

        // prevent sql injection
        $watchID = mysql_prep($_GET["watchID"]);

        // delete item from user's watch list
        delete_auction_from_watchlist($watchID);
        $_SESSION["message"] = "Auction was removed successfully";

        // redirect user back to watchlist
        // TODO redirect to specific page once pagination is implemented.
        redirect_to("watch_list.php");
    } else {
        // user visits delete watch_list page directly and watchID is not present
        redirect_to("watch_list.php");
    }

} else {
    // User is not logged in
    redirect_to("loginPage.php");
}

?>