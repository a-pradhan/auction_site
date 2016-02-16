<?php
  function find_all_live_auctions() {
  global $connection;
  $query = "SELECT * ";
  $query .= "FROM Auction ";
  $query .= "WHERE auctionLive = 1 ";
  $auction_set = mysqli_query($connection,$query);
  confirm_query($auction_set);
  return $auction_set;
  }

 function find_item_for_live_auction($itemID) {
  global $connection;
  $query = "SELECT * ";
  $query .= "FROM Item ";
  $query .= "WHERE itemID = {$itemID} ";
  $query .= "LIMIT 1";
  $item_set = mysqli_query($connection,$query);
  confirm_query($item_set);
  return $item_set;
 }

function find_auction_for_chosen_item($itemID) {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM Auction ";
    $query .= "WHERE itemID = {$itemID} ";
    $query .= "LIMIT 1";
    $item_set = mysqli_query($connection,$query);
    confirm_query($item_set);
    return $item_set;
}

 function confirm_query($result_set) {
  if (!$result_set) {
   die("Database query failed.");
   }
  }


?>

/**
 * Created by PhpStorm.
 * User: sadiq
 * Date: 10/02/16
 * Time: 20:13
 */