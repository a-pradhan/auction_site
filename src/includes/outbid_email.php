<?php require_once("../includes/auction_functions.php"); ?>


<?php


    function outbid_email($bidderUserName, $bidderEmail, $auctionName, $latestBidAmount, $auctionExpiry) {
        $message = ("Dear {$bidderUserName}\n\nYou have just been outbid on {$auctionName}, latest bid is £ {$latestBidAmount}. The auction will expire on {$auctionExpiry}.\n\nYours sincerely,\n\nTeam Auction Vault");
        send_mail($bidderEmail,$message);
    }


$bidderUserName =$_POST['bidderUserName_ajax'] ;
$bidderEmail =$_POST['bidderEmail_ajax'] ;
$auctionName =$_POST['auctionName_ajax'] ;
$latestBidAmount =$_POST['latestBidAmount_ajax'] ;
$auctionExpiry =$_POST['auctionExpiry_ajax'] ;


outbid_email($bidderUserName, $bidderEmail, $auctionName, $latestBidAmount, $auctionExpiry);


?>
