<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php"); ?>


<h5>Ajax call</h5>

<?php

echo htmlentities($_POST['auctionID_ajax']) . "<br />";
echo htmlentities($_POST['roleID_ajax']) . "<br />";
echo htmlentities($_POST['rating_ajax']) . "<br />";


$auctionID =$_POST['auctionID_ajax'] ;
$auctionID_asNumber = intval($auctionID);
//$roleID =$_POST['roleID_ajax'];
$roleID_asNumber = retrieve_buyer_roleID_from_specified_auctionID($auctionID_asNumber);
$rating_value = $_POST['rating_ajax'];
$rating_value_asNumber = intval($rating_value);


sellerRated_set_to_true_for_auction($auctionID_asNumber);
send_a_rating($auctionID_asNumber,$roleID_asNumber,$rating_value_asNumber);


?>

<div id="stage">
</div>