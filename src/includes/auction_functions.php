<?php require_once("db_connection.php") ?>
<?php

//Comment
function find_all_live_auctions()
{
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM Auction ";
    $query .= "WHERE auctionLive = 1 ";
    $auction_set = mysqli_query($connection, $query);
    //confirm_query($auction_set);
    return $auction_set;
}

function find_all_non_live_auctions()
{
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM Auction ";
    $query .= "WHERE auctionLive = 0 ";
    $auction_set = mysqli_query($connection, $query);
    //confirm_query($auction_set);
    return $auction_set;
}



    function validate_live_auction($auctionID){
        global $connection;
        $query = "UPDATE `Auction` SET `auctionLive`= 0 WHERE auctionID={$auctionID}";
        $query_sent= mysqli_query($connection,$query);
        confirm_query($query_sent);
    }



    function render_auction_unsuccessful($auctionID){
        global $connection;
        $query = "UPDATE `Auction` SET `auctionUnsuccessful`= 1 WHERE auctionID ={$auctionID}";
        $query_sent= mysqli_query($connection,$query);
        confirm_query($query_sent);
    }

    function render_auction_successful($auctionID){
        global $connection;
        $query = "UPDATE `Auction` SET `auctionSuccessful`= 1 WHERE auctionID = {$auctionID}";
        $query_sent= mysqli_query($connection,$query);
        confirm_query($query_sent);
    }

    function render_finalBid_True_for_successful_auctions($winning_bidID){
        global $connection;
        $query = "UPDATE `Bid` SET `finalBid` = 1 WHERE bidID = {$winning_bidID}";
        $query_sent= mysqli_query($connection,$query);
        confirm_query($query_sent);


    }

    function render_item_sold_True_for_successful_auctions ($sold_itemID){
        global $connection;
        $query = "UPDATE `Item` SET `sold`= 1 WHERE itemID= {$sold_itemID}";
        $query_sent= mysqli_query($connection,$query);
        confirm_query($query_sent);
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


    $refined_auction_set = mysqli_query($connection, $query);
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


function find_auction_for_chosen_item($itemID)
{
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM Auction ";
    $query .= "WHERE itemID = {$itemID} ";
    $query .= "LIMIT 1";
    $item_set = mysqli_query($connection, $query);
    confirm_query($item_set);
    return $item_set;
}

    function retrieve_buyerID_from_loggedIn_userID($loggedIn_userID){
        global $connection;
        $query = "SELECT `roleID` FROM `Role` WHERE userID = {$loggedIn_userID} AND typeID = 'Buyer' ";
        $buyerID_typeID_set = mysqli_query($connection,$query);
        confirm_query($buyerID_typeID_set);
        $buyerID_typeID_set_row = mysqli_fetch_assoc($buyerID_typeID_set);
        $buyerID_identified = $buyerID_typeID_set_row["roleID"];
        return $buyerID_identified;
    }

    function bid_an_amount($chosen_auction_ID,$bidAmount,$loggedIn_userID)
    {
        $buyer_roleID = retrieve_buyerID_from_loggedIn_userID($loggedIn_userID);

        global $connection;
        $query="INSERT INTO `Bid` (auctionID, bidTimestamp, bidAmount,finalBid,roleID) VALUES ( {$chosen_auction_ID} ,1999, '{$bidAmount}', 0, {$buyer_roleID})";

        $bid_sent =mysqli_query($connection, $query);
        confirm_query($bid_sent);

    }

    function update_bid_on_auction($auctionID,$bidID){
        global $connection;
        $query ="UPDATE `Auction` SET `bidID` = {$bidID} WHERE auctionID={$auctionID}";
        $query_sent= mysqli_query($connection,$query);
        confirm_query($query_sent);

    }

    function retrieve_bidID_for_recent_bid($chosen_auction_ID, $bid_amount) {
        global $connection;
        $query = "SELECT * ";
        $query .="FROM `Bid` ";
        $query .= "WHERE auctionID ={$chosen_auction_ID} ";
        $query .= "AND bidAmount ={$bid_amount}";
        $theBid= mysqli_query($connection,$query);
        confirm_query($theBid);
        return $theBid;
    }

    function find_bidAmount_for_bidID($bidID){
        global $connection;
        $query = "SELECT * FROM `Bid` WHERE bidID = {$bidID}";
        $bidAmount_set= mysqli_query($connection,$query);
        confirm_query($bidAmount_set);
        return $bidAmount_set;
    }

    function find_bids_for_live_auction($auctionID) {
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM Bid ";
        $query .= "WHERE auctionID = {$auctionID} ";
        $query .= "ORDER BY bidAmount DESC ";
        $bid_set = mysqli_query($connection,$query);
        confirm_query($bid_set);
        return $bid_set;
    }

    function find_userName_for_bidder($roleID){
        global $connection;
        $query = "SELECT userName ";
        $query .= "FROM User as u ";
        $query .= "LEFT JOIN Role as r ";
        $query .= "ON u.userID=r.userID ";
        $query .= "WHERE roleID= {$roleID}";

        $userName = mysqli_query($connection,$query);
        confirm_query($userName);
        return $userName;
    }

    function confirm_query($result_set) {
      if (!$result_set) {
       die("Database query failed.");
       }
    }



function filter_categories($columnName)
{
    global $connection;
    $query = "SELECT COLUMN_TYPE ";
    $query .= "FROM information_schema.COLUMNS ";
    $query .= "WHERE TABLE_SCHEMA = 'AuctionSite' ";
    $query .= "AND TABLE_NAME = 'Item' ";
    $query .= "AND COLUMN_NAME = '{$columnName}' ";

    $category_set = mysqli_query($connection, $query);
    confirm_query($category_set);

    return $category_set;
}

?>

