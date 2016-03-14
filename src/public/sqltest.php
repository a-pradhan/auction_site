<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php") ?>

<?php



$live_auctions = find_all_live_auctions();
 if($live_auctions) {
     echo "<br />";

     echo "shako mako positive";
     echo "<br />";
     while($auction=mysqli_fetch_assoc($live_auctions)) {
         $live_itemID = $auction["itemID"];
         echo $live_itemID;
         echo "<br />";
         $item_info = find_item_for_live_auction($live_itemID);
         $live_item_info = mysqli_fetch_assoc($item_info);
         echo htmlentities($live_item_info["itemName"]);
         echo "<br />";
         echo "Quantity: " . htmlentities($live_item_info["itemQuantity"]);
         echo "<br />";
         echo "Reserve price: ". htmlentities("£ ") . htmlentities($auction["auctionReservePrice"]);
         echo "<br />";
         echo "Description " .htmlentities($live_item_info["itemDescription"]);
         echo "<br />";
         echo "Category " . htmlentities($live_item_info["itemCategory"]);
         echo "<br />";
         echo "Link " . htmlentities($live_item_info["itemPhoto"]);
         echo "<br />";


     }

 } else {
     echo "<br />";

     echo "shako mako negative";
     echo "<br />";

 }

?>