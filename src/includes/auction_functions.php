<?php require_once("db_connection.php") ?>
<?php
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

    function validate_live_auction($auctionID){
        global $connection;
        $query = "UPDATE `Auction` SET `auctionLive`= 0 WHERE auctionID={$auctionID}";
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


    function bid_an_amount($chosen_auction_ID,$bidAmount)
    {
        global $connection;
        $query="INSERT INTO `Bid` (auctionID, bidTimestamp, bidAmount,finalBid,roleID) VALUES ( {$chosen_auction_ID} ,1999, '{$bidAmount}', 0, 2000)";

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

