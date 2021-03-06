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
    $query .= "WHERE w.userID = {$safe_userID} ";
    $query .= "ORDER BY a.auctionEnd ASC";

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

// checks to see if an auction is already in the users watch list
function is_auction_in_watchlist($userID, $auctionID)
{

    global $connection;

    $query = "SELECT auctionID FROM WatchList WHERE userID = {$userID} AND auctionID = {$auctionID}";
    $watched_auctions_set = mysqli_query($connection, $query);

    // returns true if the user is already watching the auction, otherwismysqli_num_rows($watched_auctions_set) > 0e returns false
    return mysqli_num_rows($watched_auctions_set) > 0 ? true : false;

}

// add an auction to the users watch list. Returns true if successful otherwise adds
// a message to the $_SESSION['message'] variable

function add_auction_to_watchlist($userID, $auctionID)
{
    global $connection;

    $safe_userID = $userID;
    $safe_auctionID = $auctionID;


    $query = "INSERT INTO WatchList (";
    $query .= "auctionID, userID ) ";
    $query .= "VALUES ({$safe_auctionID}, {$safe_userID})";

    $result = mysqli_query($connection, $query);

    return $result;

}

?>