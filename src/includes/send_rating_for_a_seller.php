<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php"); ?>

<?php

$auctionID =$_POST['auctionID_ajax'] ;
$auctionID_asNumber = intval($auctionID);
//$roleID =$_POST['roleID_ajax'];
$roleID_set = retrieve_seller_roleID_from_specified_auctionID($auctionID_asNumber);
$roleID = mysqli_fetch_assoc($roleID_set);
$roleID_asNumber = intval($roleID['roleID']);
$rating_value = $_POST['rating_ajax'];
$rating_value_asNumber = intval($rating_value);


buyerRated_set_to_true_for_auction($auctionID_asNumber);
send_a_rating($auctionID_asNumber,$roleID_asNumber,$rating_value_asNumber);


?>

<div id="stage"></div>
