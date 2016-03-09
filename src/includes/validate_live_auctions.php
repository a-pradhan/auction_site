<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/session.php"); ?>


<?php


//validating live auctions
$live_auctions = find_all_live_auctions();
    while ($auction = mysqli_fetch_assoc($live_auctions)) {
        //Format to be used in the actual auctionStart and auctionEnd
        $auctionID=$auction["auctionID"];
        $date = new DateTime();
        //echo $date->format('Y-m-d g:i:s');
        $date2String = $auction["auctionEnd"];
        $date2 = new DateTime("" . $date2String);
        //echo $date2->format('Y-m-d g:i:s');

        if ($date > $date2) {
            validate_live_auction($auctionID);
        }
    }

?>