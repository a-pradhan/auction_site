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

    function refined_live_auctions($item_category,$item_condition){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM Auction,Item ";
        $query .= "WHERE auctionLive = 1 ";
        if ($item_category) {
            $query .= "AND itemCategory = '{$item_category}' ";
        }
        if ($item_condition){
            $query .= "AND itemCondition = '{$item_condition}' ";
        }
        $query .= "AND Auction.itemID = Item.itemID";

        $refined_auction_set = mysqli_query($connection,$query);
        confirm_query($refined_auction_set);
        return $refined_auction_set;

    }

function search_live_auctions($auction_search_string) {
        global $connection;
        if ($auction_search_string) {

            if (sizeof($auction_search_string) > 1) {
                $array_counting = 1;
                foreach ($auction_search_string as $auction_search) {


                    $query = "(SELECT * ";
                    $query .= "FROM Auction AS a ";
                    $query .= "LEFT JOIN Item AS i ";
                    $query .= "ON a.itemID = i.itemID ";
                    $query .= "WHERE auctionLive = 1 ";
                    $query .= "AND itemCategory LIKE '%{$auction_search}%' ";
                    $query .= "OR itemName LIKE '%{$auction_search}%' ";
                    $query .= "OR itemDescription LIKE '%{$auction_search}%') ";
                    while ($array_counting != sizeof($auction_search_string)) {
                        $query .= " UNION ";
                        $array_counting++;

                    }


                }

            }   else    {
                    $query = "SELECT * ";
                    $query .= "FROM Auction AS a ";
                    $query .= "LEFT JOIN Item AS i ";
                    $query .= "ON a.itemID = i.itemID ";
                    $query .= "WHERE auctionLive = 1 ";
                    $query .= "AND itemCategory LIKE '%{$auction_search_string[0]}%' ";
                    $query .= "OR itemName LIKE '%{$auction_search_string[0]}%' ";
                    $query .= "OR itemDescription LIKE '%{$auction_search_string[0]}%' ";


                }


            }
        $search_auction_set = mysqli_query($connection,$query);
        confirm_query($search_auction_set);
        return $search_auction_set;
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


    function filter_categories($columnName){
        global $connection;
        $query = "SELECT COLUMN_TYPE ";
        $query .= "FROM information_schema.COLUMNS ";
        $query .= "WHERE TABLE_SCHEMA = 'AuctionSite' ";
        $query .= "AND TABLE_NAME = 'Item' ";
        $query .= "AND COLUMN_NAME = '{$columnName}' ";

        $category_set = mysqli_query($connection,$query);
        confirm_query($category_set);

        return $category_set;
    }

?>

/**
 * Created by PhpStorm.
 * User: sadiq
 * Date: 10/02/16
 * Time: 20:13
 */