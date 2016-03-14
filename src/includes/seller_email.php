<?php require_once("../includes/auction_functions.php"); ?>


<?php

$sellerUserName =$_POST['sellerUserName_ajax'] ;
$sellerEmail =$_POST['sellerEmail_ajax'] ;
$auctionName =$_POST['auctionName_ajax'] ;
$latestBidAmount =$_POST['latestBidAmount_ajax'] ;
$auctionExpiry =$_POST['auctionExpiry_ajax'] ;
$auctionViewings =$_POST['auctionViewings_ajax'] ;
$auctionBids =$_POST['auctionBids_ajax'] ;



seller_email($sellerUserName, $sellerEmail, $auctionName, $latestBidAmount, $auctionExpiry, $auctionViewings, $auctionBids);

?>

