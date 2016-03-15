<?php require_once("../includes/auction_functions.php"); ?>


<?php

$auctionID =$_POST['auctionID_ajax'] ;
$auctionName =$_POST['auctionName_ajax'] ;
$latestBidAmount =$_POST['latestBidAmount_ajax'] ;
$auctionExpiry =$_POST['auctionExpiry_ajax'] ;
$auctionBids =$_POST['auctionBids_ajax'] ;



watch_list_email($auctionID,$auctionName,$latestBidAmount,$auctionExpiry,$auctionBids);

?>

