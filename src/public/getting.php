<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php") ?>

<?php
    // Retrieve the itemID for the auction selected
    $chosen_auction = $_GET["auction"];

    // Retrieve the auction row for the auction selected using the itemID
    $chosen_auction_info = mysqli_fetch_assoc(find_auction_for_chosen_item($chosen_auction));

    // Fetch the item info from Item table using the itemID
    $chosen_item_info = find_item_for_live_auction($chosen_auction);
    $chosen_live_item_info = mysqli_fetch_assoc($chosen_item_info);

    echo "<br />";
    echo "Hello";
    echo "<br />";
    echo htmlentities($chosen_live_item_info["itemName"]);
    echo "<br />";
    echo htmlentities($chosen_live_item_info["itemQuantity"]);
    echo "<br />";
    echo htmlentities($chosen_live_item_info["itemCategory"]);
    echo "<br />";
    echo htmlentities($chosen_live_item_info["itemDescription"]);
    echo "<br />";
    echo htmlentities($chosen_auction_info["auctionReservePrice"]);
    echo "<br />";
    echo htmlentities($chosen_live_item_info["itemPhoto"]);

?>