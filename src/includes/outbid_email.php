<?php require_once("../includes/auction_functions.php"); ?>


<?php

$bidderUserName =$_POST['bidderUserName_ajax'] ;
$bidderEmail =$_POST['bidderEmail_ajax'] ;
$auctionName =$_POST['auctionName_ajax'] ;
$latestBidAmount =$_POST['latestBidAmount_ajax'] ;
$auctionExpiry =$_POST['auctionExpiry_ajax'] ;


outbid_email($bidderUserName, $bidderEmail, $auctionName, $latestBidAmount, $auctionExpiry);


?>

