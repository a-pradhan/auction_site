<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/auction_functions.php") ?>

<?php
//Comments
//checks all auctions where auctionLive=0
//it then checks if the bid assigned to the auctions is higher than the reserver price
//if the bid is higher than the reserver price the auction becomes successful and the item table will contain the roleID of 'Buyer' and also the sold attribute will become 1 (for true, in terms of TINYINT)
//otherwise the auction is rendered unsuccessful

    $expired_auctions = find_all_non_live_auctions();

    while ($expired_single_auction = mysqli_fetch_assoc($expired_auctions)) {

        $expired_auction_bidID = $expired_single_auction["bidID"];
        $expired_auctionID = $expired_single_auction["auctionID"];



        if($expired_auction_bidID == null){
            //The auction becomes true for auctionUnsuccessful
            render_auction_unsuccessful($expired_auctionID);
        } else {

            $bid_amount_set = mysqli_fetch_assoc(find_bidAmount_for_bidID($expired_auction_bidID));

            $expired_auction_bid_amount = $bid_amount_set['bidAmount'];
            $expired_auction_reserve_price = $expired_single_auction["auctionReservePrice"];



            if ($expired_auction_bid_amount >= $expired_auction_reserve_price) {
                //auction becomes true for auctionSuccessful
                //item becomes true for sold
                //item contains a newOwner
                render_auction_successful($expired_auctionID);

                //render the winning bid as 'True' for finalBid attribute in the bid table


                render_finalBid_True_for_successful_auctions($expired_auction_bidID);

                //render the item as 'True' for sold attribute in the Item table

                $sold_itemID = $expired_single_auction["itemID"];

                render_item_sold_True_for_successful_auctions($sold_itemID);


            } else {
                //auction becomes true for actionUnsuccessful
                render_auction_unsuccessful($expired_auctionID);


            }
        }

    }


?>