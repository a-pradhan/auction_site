<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php") ?>


    <link href="../css/public.css" rel="stylesheet">

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

echo "<hr>";
echo "<div>";
echo "<label>Name:</label><input type=\"text\">";
echo "<label>Email Address:</label><input type = \"text\">";
echo "<label>Description of the input value:</label><input type=\"text\">";
echo "</div>";
echo "<br /><br /><br /><br />";
echo "<hr>";


echo "<br /><br /><br /><br />";
echo "<hr>";
$columnName = "itemCategory";
$category_enums = filter_categories($columnName);
echo print_r($category_enums);
echo "<br />";
$category_enums = "enum('Car','Bike','Plane')";
echo print_r($category_enums);
$output = str_replace("enum('", "", $category_enums);
echo print_r("Khello");
echo "<br />";
$output = str_replace("')", "", $output);
echo print_r("Khello");
echo "<br />";
$results = explode("','", $output);
echo print_r("Khello");
echo "<br />";
echo print_r($results);
echo "<div>";
echo "<select>";
while ($category = mysqli_fetch_assoc($categories)) {
    echo "<option value=\"null\">" . htmlentities($category) . "</option>";
}
echo "</select>";
echo "</div>";

?>