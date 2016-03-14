<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/auction_functions.php"); ?>
<?php require_once("../includes/validate_live_auctions.php"); ?>
<?php require_once("../includes/awardSuccessful_auctions.php"); ?>


<?php
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$loggedIn_userID = $_SESSION["userID"];
?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auction Vault</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
    <link href="../css/create_auctionStyling.css" rel="stylesheet">


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

<body style="background-color: #dbdbdb">

<!-- Navigation -->
<?php include("../includes/layouts/navbar.php") ?>
<!-- Page Content -->
<div class="container">

    <div class="col-sm-12">
        <h1 class="page-title">My Auctions</h1>
        <div class="row panel panel-default panel-shadow">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Auction</th>
                        <th>Time left</th>
                        <th>Reserve price</th>
                        <th>Highest bid</th>
                        <th>Total bids</th>
                        <th>Total viewing</th>
                        <th>Sold</th>
                        <th>Rate buyer</th>
                    </tr>
                    </thead>
                    <tbody>
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
                    </script>
                    <?php
                    $my_auctions_sellerID = retrieve_sellerID_from_loggedIn_userID($loggedIn_userID);

                    $all_my_auctions = retrieve_my_auctions($my_auctions_sellerID);
                    $counter = 0;

                    while ($my_auction = mysqli_fetch_assoc($all_my_auctions)) {


                        $my_auction_latest_bidID = $my_auction['bidID'];


                        $my_auction_latest_bidAmount = "N/A";
                        if ($my_auction_latest_bidID == null) {


                        } else {
                            $my_auction_latest_bidID = $my_auction['bidID'];
                            $bid_amount_set = mysqli_fetch_assoc(find_bidAmount_for_bidID($my_auction_latest_bidID));
                            $my_auction_latest_bidAmount = "£ " . $bid_amount_set['bidAmount'];
                        }

                        $bid_set_for_given_auction = retrieve_number_of_bids_for_a_given_auction($my_auction["auctionID"]);
                        $number_of_bids = mysqli_fetch_assoc($bid_set_for_given_auction);

                        if (true) {
                            $sold_icon_success = null;
                        } else {
                            $sold_icon_unsuccessful = null;
                        }
                        $boolcheck = false;
                        $auction_successful = $my_auction["auctionSuccessful"];
                        echo "<tr>";
                        echo "<td>" . $my_auction['itemName'] . "</td>";
                        echo "<td><div id=\"" . "{$counter}" . "\"></div></td>";
                        echo "<td>£ " . $my_auction['auctionReservePrice'] . "</td>";
                        echo "<td>" . $my_auction_latest_bidAmount . "</td>";
                        echo "<td>" . $number_of_bids["COUNT(bidID)"] . "</td>";
                        echo "<td>" . $my_auction['auctionViewings'] . "</td>";

                        //this if statement is for the 'Sold' column and 'Rate' column respectively
                        if ($auction_successful == 1) {

                            echo "<td><span style=\"color:green\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></td>";
                            echo "<td><div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
                            echo "<button type=\"button\" id=\"rate\"  class=\"btn btn-black\" data-toggle=\"modal\" data-target=\"#myModal\"";

                            $seller_has_rated_this_auction_set = mysqli_fetch_assoc(has_seller_rated_this_auction($my_auction['auctionID']));
                            if ($seller_has_rated_this_auction_set['sellerRated'] == 1) {
                                echo "disabled=\"disabled\"";
                            }


                            echo ">Rate buyer</button></div></td>";

                            ?>
                            <script>

                                function clicked() {

                                    document.getElementById("rate").disabled = true;
                                }
                            </script>


                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            <form action="" method="POST">
                                                <h4 class="modal-title">Please select a rating

                                                    <select name="ratingList">
                                                        <option value="0"></option>
                                                        <option value="1">1 - Do not recommend</option>
                                                        <option value="2">2 - Poor</option>
                                                        <option value="3">3 - Average</option>
                                                        <option value="4">4 - Recommend</option>
                                                        <option value="5">5 - Good</option>
                                                    </select></h4>
                                        </div>

                                        <div class="modal-footer">
                                            <input id="submit" name="submit" type="submit" value="Submit">
                                        </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                            <?php

                            if (isset($_POST['submit'])) {
                                if ($_POST["ratingList"] == 0) {
                                    echo "<p style =\"color:red;\">You must select a rating.</p>";
                                } else {
                                    //set the button to disabled
                                    sellerRated_set_to_true_for_auction($my_auction['auctionID']);
                                    echo "<script>clicked();</script>";


                                    $auctionID = $my_auction['auctionID'];
                                    $roleID = retrieve_sellerID_from_loggedIn_userID($loggedIn_userID);
                                    $ratingValue = $_POST["ratingList"];
                                    send_a_rating($auctionID, $roleID, $ratingValue);


                                }
                            }


                        } else {
                            echo "<td><span style=\"color:red\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></td>";
                            echo "<td>" . "Not applicable" . "</td>";

                        }

                        echo "<tr>";

                        $counter++;

                    }


                    ?>

                    <?php
                    $my_auctions_sellerID = retrieve_sellerID_from_loggedIn_userID($loggedIn_userID);
                    //            echo htmlentities($my_auctions_sellerID);
                    $all_my_auctions = retrieve_my_auctions($my_auctions_sellerID);
                    $counter = 0;
                    //A second loop to assign left to each pre-defined <div> in precvious while-loop
                    while ($my_auction = mysqli_fetch_assoc($all_my_auctions)) {

                        $auctionEnd = $my_auction["auctionEnd"];


                        ?>
                        <script>
                            var <?php echo "t{$counter}"; ?> = <?php echo json_encode($my_auction["auctionEnd"]); ?>;

                            var <?php echo "d{$counter}"; ?> =
                            Date.createFromMysql(<?php echo "t{$counter}"; ?>);

                            <?php $div_counter = "clock{$counter}"; ?>

                            $(<?php echo "'#" . "{$counter}" . "'"; ?>).countdown(<?php echo "d{$counter}"; ?>, function (event) {
                                var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                                $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
                            });
                        </script>

                        <?php
                        $counter++;
                    }
                    ?>


                    </tbody>
                </table>
            </div>
        </div>

        <footer>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Team 40 Money Motivation</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>


    <!-- Footer -->

</div>

<!-- /.container -->

<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>

</html>
