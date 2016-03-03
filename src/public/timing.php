<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php") ?>


<?php
//validating live auctions
    $live_auctions = find_all_live_auctions();
    while ($auction = mysqli_fetch_assoc($live_auctions)) {

        //Format to be used in the actual auctionStart and auctionEnd
        $auctionID=$auction["auctionID"];
        $date = new DateTime();
        //echo $date->format('Y-m-d g:i:s');
        //echo "<br />";
        $date2String = $auction["auctionEnd"];
        $date2 = new DateTime("" . $date2String);
        //echo $date2->format('Y-m-d g:i:s');
        //echo "<br />";

        if ($date > $date2) {
            //echo "<br />";
            //echo "Auction expired";
            validate_live_auction($auctionID);
            //echo "<br />";
        }
    }

?>
<script src="../js/jquery.js"></script>
<script src="../js/jquery.countdown.js"></script>
<script src="../js/jquery.countdown.min.js"></script>



<?php


// Retrieve all live auctions (auctionLive =1)
$live_auctions = find_all_live_auctions();

while ($auction = mysqli_fetch_assoc($live_auctions)) {

    // Retrieving the itemID for each row of auction
    $live_itemID = $auction["itemID"];

    // Retrieving the row for the auction item from Item table
    $live_item_info = mysqli_fetch_assoc(find_item_for_live_auction($live_itemID));
    //$live_item_info = mysqli_fetch_assoc($item_info);
    echo "Live! <br>";
    echo "<div class=\"row\">";
    echo "<div class=\"col-md-3\">";
    echo "<a href=\"#\">";
    echo "<img class=\"img-responsive\" src=\"../images/" . $live_item_info["itemPhoto"] . "\" alt=\"\">";
    echo "</a>";
    echo "</div>";
    echo "<div class=\"col-md-6\">";
    echo "<h3>auctionStart " . htmlentities($auction["auctionStart"]) . "</h3>";
    echo "<h3>auctionEnd " . htmlentities($auction["auctionEnd"]) . "</h3>";
    $auction_end_time = $auction["auctionEnd"];
    ?>
    <p id="demo"></p>
    <h6>Time remaining:<div id="clock"></div></h6>
    <script>

        Date.createFromMysql = function(mysql_string)
        {
            var t, result = null;

            if( typeof mysql_string === 'string' )
            {
                t = mysql_string.split(/[- :]/);

                //when t[3], t[4] and t[5] are missing they defaults to zero
                result = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
            }

            return result;
        }

        var t = <?php echo json_encode($auction_end_time) ; ?>;

        var d = Date.createFromMysql(t);
        document.getElementById("demo").innerHTML = d;

        $('#clock').countdown(d, function(event) {
              var totalHours = event.offset.totalDays * 24 + event.offset.hours;
            $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
        });


    </script>



    <?php

    echo "<h3>" . htmlentities($live_item_info["itemName"]) . "</h3>";
    echo "<h4>" . htmlentities($live_item_info["itemCategory"]) . "</h4>";
    echo "<h6><span style=\"font-weight:bold\">" . "Quantity: </span>" . htmlentities($live_item_info["itemQuantity"]) . "" . "<span style=\"color:#880000 ;text-align:center;float: right\">Reserve price at £" . htmlentities($auction["auctionReservePrice"]) . "</span></h6>";
    echo "<h6><span style=\"font-weight:bold\">" . "Condition: </span>" . htmlentities($live_item_info["itemCondition"]) . "</h6>";
    echo "<p>" . htmlentities($live_item_info["itemDescription"]) . "</p>";
    echo "<a style= \"float:right;\"  class=\"btn btn-primary\" href=\"auction_view.php?auction=" . urlencode($live_item_info["itemID"]) . "\" >View More<span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
    echo "</div>";
    echo "</div>";
    echo "<hr>";
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Check Date Validity</title>

    <?php
    //Format to be used in the actual auctionStart and auctionEnd
    $date = new DateTime();
    echo $date->format('Y-m-d g:i:s');
    echo "<br />";
    $date2String="2016-03-02 23:44:30";
    $date2 = new DateTime("" . $date2String);
    echo $date2->format('Y-m-d g:i:s');

    if ($date>$date2) {
        echo "<br />";
        echo "Auction expired";
    }
    ?>


</head>
<body>
<h1>Check Date</h1>
<form method="post">
    <p>
        <label for="month">Month: </label>
        <select name="month" id="month">
            <?php
            // Only the key for January is set explicitly.
            // The other months increment the key automatically.
            $months = [1 => 'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            foreach ($months as $key => $value) {
                echo "<option value='$key'>$value</option>";
            }
            ?>
        </select>
        <label for="day">Day: </label>
        <select name="day" id="day">
            <?php
            for ($i = 1; $i <= 31; $i++) {
                echo "<option>$i</option>";
            }
            ?>
        </select>
        <label for="year">Year: </label>
        <input type="text" name="year" id="year" list="year_list">
        <!-- A datalist creates an editable drop-down menu in HTML5 browsers. -->
        <datalist id="year_list">
            <?php
            $thisyear = date('Y');
            $limit = $thisyear + 5;
            while ($thisyear <= $limit) {
                echo "<option value='$thisyear'></option>";
                $thisyear++;
            }
            ?>
        </datalist>
    </p>
    <p>
        <input type="submit" name="check" value="Check Date">
    </p>
</form>
<?php
if (isset($_POST['check'])) {
    $month = $_POST['month'];
    $day = $_POST['day'];
    $year = $_POST['year'];
    echo "<p>Date submitted: $months[$month] $day, $year";

    if (checkdate($month,$day,$year)){
        echo "is valid.</p>";
    } else {
        echo "is not valid.</p>";
    }
}
?>
</body>
</html>

