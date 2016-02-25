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




    echo "<br /><br /><br /><br />";
    echo "<hr>";
    $columnName = "itemCategory";
    $category_enums = filter_categories($columnName);
    echo print_r($category_enums);
    echo "<br />";
    $category_enums ="enum('Car','Bike','Plane')";
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
    echo    "<div>";
    echo            "<select>";
    while ($category=mysqli_fetch_assoc($categories)) {
        echo "<option value=\"null\">" . htmlentities($category) ."</option>";
    }
    echo            "</select>";
    echo    "</div>";
    echo "<br /><br /><br /><br />";
    echo "<hr>";
    echo "Khello";

    echo "<div>"; ?>
        <form action="getting.php?auction=3000" method="POST">
                            <input id="search" name="searchField" type="text" style="width: 500px;" placeholder="Search by name, description or category of item!">
                            <input id="submit" type="submit" value="Search">
        </form>
 <?php
            echo "<br />";

            echo "<br />";
        if (isset($_POST['searchField'])){
            echo "<br />";

            echo "<br />";
            global $connection;
            $search_string_identified = mysqli_real_escape_string($connection, $_POST["searchField"]);
            echo htmlentities($search_string_identified);
            echo "<br />";
            echo htmlentities($search_string_identified);
            $auction_search_array = explode (" ", $search_string_identified);
            echo "Did it work?";
            echo "<br />";
            echo htmlentities($auction_search_array[0]);
            echo "<br />";
            //echo htmlentities(sizeof($auction_search_array));
            echo "<br />";
            $search_auction_set = search_live_auctions($auction_search_array);
            echo "1";
            echo "<br />";
             while ($auction = mysqli_fetch_assoc($search_auction_set)) {
                 echo "2";
                 echo "<br />";
                 $live_itemID = $auction["itemID"];
                 // Retrieving the itemID for each row of auction
                 echo htmlentities($live_itemID);
                 echo "3";
                 echo "<br />";
                 // Retrieving the row for the auction item from Item table
                 echo "4";
                 echo "<br />";
                 echo "5";
                 echo "<br />";
                 echo "<br />";
             }
            echo "6";
            echo "<br />";

        }
    echo   "</div>";
    ?>





?>