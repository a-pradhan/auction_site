<?php
require_once("db_connection.php");
require_once("general_functions.php");
/**
 * Contains functions that are used on the watch list page or that are related
 * specifically to the behaviour of the watch list
 */

// returns a result set containing all of the auctions that a user has added to their watch list and their
// relevant item info
function find_users_watched_items($userID)
{
    global $connection;

    $safe_userID = mysql_prep($userID);

    $query = "SELECT * FROM WatchList w ";
    $query .= "JOIN Auction a ";
    $query .= "ON w.auctionID = a.auctionID ";
    $query .= "JOIN Item i ";
    $query .= "ON a.itemID = i.itemID ";
    $query .= "WHERE w.userID = {$safe_userID}";

    $result = mysqli_query($connection, $query);
    // confirm_query($result);

    return $result;

}





// deletes a watched auction from a user's watch list
function delete_auction_from_watchlist($watchID)
{
    global $connection;
    $safe_watchID = mysql_prep($watchID);

    $query = "DELETE FROM WatchList ";
    $query .= "WHERE watchID = {$safe_watchID}";

    $result = mysqli_query($connection, $query);
    return $result;
}


?>