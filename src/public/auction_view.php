<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/auction_functions.php") ?>


<?php
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $loggedIn_userID = $_SESSION["admin_id"];
    echo htmlentities($username);
    echo "<br />";
    echo htmlentities($loggedIn_userID);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Item - Start Bootstrap Template</title>


    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/shop-item.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.countdown.js"></script>
    <script src="../js/jquery.countdown.min.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Auction Vault</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- Page Content -->
<?php
    // Retrieve the itemID for the auction selected
    $chosen_auction_item = $_GET["auction"];
    // Retrieve the auction row for the auction selected using the itemID
    $chosen_auction_info = mysqli_fetch_assoc(find_auction_for_chosen_item($chosen_auction_item));
    $chosen_auction_ID = $chosen_auction_info['auctionID'];
    // Fetch the item info from Item table using the itemID
    $chosen_item_info = find_item_for_live_auction($chosen_auction_item);
    $chosen_live_item_info = mysqli_fetch_assoc($chosen_item_info);
?>


<div class="container">

    <div class="row">
        <div class="col-md-5">
            <div class="thumbnail">
                <?php //retrieves the name of the photo to be shown ?>
                <img class="img-responsive" src="../images/<?php echo $chosen_live_item_info["itemPhoto"] ?>" alt="">
            </div>
        </div>

        <div class="col-md-7">
            <div class="ratings">
                <?php // A POST to store the itemID in the url ?>
                <form id="bidAmount" action="auction_view.php?auction=<?php echo $chosen_auction_item ?>" method="POST"
                      style=float:right;>
                    <input type="number" id="bidField" name="bidField" placeholder="Enter bid here!">
                    <input type="submit" name="bid" value="Bid" onclick="myFunction()">
                </form>

               <?php // JS code for retrieving the bidAmount from the bidField ?>
                <script>
                    function myFunction() {
                        confirm("Please confirm - bid amount: £" + $("#bidField").val());


                    }
                </script>



                <?php
                //Code for verifying the bidAmount and essential validations
                if (isset($_POST['bid'])) {
                    global $connection;
                    $new_bid_amount = mysqli_real_escape_string($connection, $_POST['bidField']);
                    if ($new_bid_amount == null) {
                        echo "You must enter an amount!";
                    } else {
                        if ($chosen_auction_info['bidID'] == null) {
                            //The first ever bid for an auction
                            bid_an_amount($chosen_auction_ID, $new_bid_amount,$loggedIn_userID);
                            $bidID_for_recent_bid = mysqli_fetch_assoc(retrieve_bidID_for_recent_bid($chosen_auction_ID, $new_bid_amount));
                            $bidID = $bidID_for_recent_bid['bidID'];
                            update_bid_on_auction($chosen_auction_ID, $bidID);

                        } else {
                            $previous_bidID = $chosen_auction_info['bidID'];
                            $bid_amount_set = mysqli_fetch_assoc(find_bidAmount_for_bidID($previous_bidID));
                            $previous_bid_amount = $bid_amount_set['bidAmount'];

                            if ($new_bid_amount > $previous_bid_amount) {
                                bid_an_amount($chosen_auction_ID, $new_bid_amount,$loggedIn_userID);
                                $bidID_for_recent_bid = mysqli_fetch_assoc(retrieve_bidID_for_recent_bid($chosen_auction_ID, $new_bid_amount));
                                $bidID = $bidID_for_recent_bid['bidID'];
                                update_bid_on_auction($chosen_auction_ID, $bidID);
                                echo "Bid successful!";
                            } else {
                                //new bid amount is too low, must be higher than previous amount!
                                echo "Your bid must be higher than the latest bidder!";
                            }
                        }
                        //                           $bidID_for_recent_bid = mysqli_fetch_assoc(retrieve_bidID_for_recent_bid($chosen_auction_ID, $bid_amount));
                        //                           $bidID = $bidID_for_recent_bid['bidID'];
                        //                           $bidAmount= mysqli_fetch_assoc(find_bidAmount_for_bidID($bidID));
                    }
                }
                ?>

                <p style="font-size:160%;"> Seller's ratings
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>

            </div>


        </div>
        <?php
        //code for the timerCount down
        $auction_end_time = $chosen_auction_info["auctionEnd"];
        ?>

        <div class="col-md-7">


            <div class="thumbnail">
                <div class="caption-full">
                    <h4 class="pull-right" style="color:#880000">Reserve price at
                        £ <?php echo htmlentities($chosen_auction_info["auctionReservePrice"]); ?></h4>

                    <h4><?php echo htmlentities($chosen_live_item_info["itemName"]); ?></h4>
                    <h6 class="pull-right" style="color:#880000">Time left ~
                        <div class="pull-right" id="clock"></div>
                    </h6>

                    <script>
                        //hilios.github.io/jQuery.countdown/ - reference for the timer
                        Date.createFromMysql = function (mysql_string) {
                            var t, result = null;

                            if (typeof mysql_string === 'string') {
                                t = mysql_string.split(/[- :]/);

                                //when t[3], t[4] and t[5] are missing they defaults to zero
                                result = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
                            }

                            return result;
                        }

                        var t = <?php echo json_encode($auction_end_time); ?>;

                        var d = Date.createFromMysql(t);

                        $('#clock').countdown(d, function (event) {
                            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                            $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
                        });
                    </script>

                    <p><?php echo htmlentities($chosen_live_item_info["itemCategory"]); ?></p>

                    <p><strong>
                            Quantity:</strong><?php echo " " . htmlentities($chosen_live_item_info["itemQuantity"]); ?>
                    </p>
                    <p><strong>
                            Condition:</strong><?php echo " " . htmlentities($chosen_live_item_info["itemCondition"]); ?>
                    </p>
                    <p>
                        <strong>Description:</strong><?php echo " " . htmlentities($chosen_live_item_info["itemDescription"]); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <?php
            echo "<div class=\"thumbnail\">";
            echo "<p class=\"lead\">Latest bidders!</p>";
            echo "<div class=\"list-group\">";

            $bid_set = find_bids_for_live_auction($chosen_auction_ID);
            if (mysqli_num_rows($bid_set) == 0) {
                echo "Currently no bids!";
            } else {
                $count = 0;
                while ($bids = mysqli_fetch_assoc($bid_set)) {
                    $bidderName = mysqli_fetch_assoc(find_userName_for_bidder($bids['roleID']));

                    if ($count == 0) {
                        echo "<ol class=\"list-group-item active\">" . htmlentities($bidderName['userName']) . htmlentities(" ~ ") . htmlentities(" ") . htmlentities("£") . htmlentities($bids['bidAmount']) . "</ol>";
                        $count++;
                    } else {

                        echo "<ol class=\"list-group-item\">" . htmlentities($bidderName['userName']) . htmlentities(" ~ ") . htmlentities(" ") . htmlentities("£") . htmlentities($bids['bidAmount']) . "</ol>";
                        $count++;
                    }
                }
            }
            echo "</div>";
            echo "</div>";
            ?>

        </div>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <a class="btn btn-success">Leave a Review</a>
        </div>

        <hr>


        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous
                <span class="pull-right">10 days ago</span>
                <p>This product was great in terms of quality. I would definitely buy another!</p>

            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous

                <span class="pull-right">12 days ago</span>
                <p>I've alredy ordered another one!</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous
                <span class="pull-right">15 days ago</span>
                <p>I've seen some better than this, but not at this price. I definitely recommend this item.</p>
            </div>
        </div>

    </div>

</div>


</div>
<!-- /.container -->

<div class="container">

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Your Website 2014</p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->


<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>


</body>

</html>
