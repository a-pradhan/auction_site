<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/auction_functions.php"); ?>
<?php require_once("../includes/validate_live_auctions.php"); ?>
<?php require_once("../includes/awardSuccessful_auctions.php"); ?>


<?php
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$loggedIn_userID = $_SESSION["admin_id"];
?>


<!DOCTYPE html>
<html lang="en">

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
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="auction_list.php">Auction Vault</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <div class="floatleft"></div>
                <li>
                    <a href="my_auctions.php">My Auctions</a>
                </li>
                <li>
                    <a href="my_bids.php">My Bids</a>
                </li>
                <li>
                    <a href="watch_list.php">Watch-list</a>
                </li>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact us</a>
                </li>
                <li>
                    <a href="#">About us</a>
                </li>
                <?php   //This long repetitive line is to align the Logout button far right lol XD ?>
                </li><li> <a href="#"></a></li><li><a href="#"></a></li><li><a href="#"></a> </li><li> <a href="#"></a></li><li><a href="#"></a></li><li><a href="#"></a> </li><li> <a href="#"></a></li><li><a href="#"></a></li><li><a href="#"></a> </li><li> <a href="#"></a></li><li><a href="#"></a></li><li><a href="#"></a></li><li><a href="#"></a></li>


                <li>
                    <a href="loginPage.php">Log out</a>
                </li>
            </ul>
        </div>
    </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<body>
<!-- Page Content -->

<div class="container">
    <h2>My Bids</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Auction</th>
            <th>Time left</th>
            <th>Reserve price</th>
            <th>Highest bid</th>
            <th>My bid</th>
            <th>Winning bid</th>
            <th>Rate seller</th>
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

        $my_bids_buyerID = retrieve_buyerID_from_loggedIn_userID($loggedIn_userID);
        $all_my_bids = retrieve_my_bids ($my_bids_buyerID);

        $counter=0;
        while ($my_bids = mysqli_fetch_assoc($all_my_bids)){


            $my_latest_bidAmount = "£ " . $my_bids['MAX( bidAmount )'];



            $auction_bidded_on_set = retrieve_my_auctions_for_a_given_auctionID ($my_bids['auctionID']);


            while ($auction_bidded_on = mysqli_fetch_assoc($auction_bidded_on_set)){

                $bid_amount_set = mysqli_fetch_assoc(find_bidAmount_for_bidID($auction_bidded_on['bidID']));

                $auction_highest_bid = "£ " . $bid_amount_set['bidAmount'];


                $my_auction_latest_bidID = $auction_bidded_on['bidID'];

                $bid_amount_set = mysqli_fetch_assoc(find_bidAmount_for_bidID($my_auction_latest_bidID));
                $my_auction_latest_bidAmount = "£ " . $bid_amount_set['bidAmount'];


                $auction_successful = $auction_bidded_on["auctionSuccessful"];

                echo "<tr>";
                echo "<td>" . $auction_bidded_on["itemName"] . "</td>";
                echo "<td><div id=\"" . "{$counter}"  ."\"></div></td>";
                echo "<td>£ " . $auction_bidded_on["auctionReservePrice"] . "</td>";
                echo "<td>" . $my_auction_latest_bidAmount  . "</td>";
                echo "<td>" . $my_latest_bidAmount. "</td>";
                if ($auction_successful == 1 && ($my_latest_bidAmount >= $my_auction_latest_bidAmount)) {

                    echo "<td><span style=\"color:green\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></td>";
                    echo "<td><div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
                    echo "<button type=\"button\" id=\"rate\" class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModal\"";

                    

                    echo "disabled=\"disabled\">";
                    echo "Rate seller</button></div></td>";
                    //onClick="this.disabled=true;"

        ?>
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <form action="" method="POST">
                                        <h4 class="modal-title">Please select a rating

                                            <select name="ratingList">
                                                <option value="0"></option>
                                                <option value="1">1 - Do not recommend</option>
                                                <option value="2">2 - Poor</option>
                                                <option value="3">3 - Average</option>
                                                <option value="4">4 -  Recommend</option>
                                                <option value="5">5 -  Good</option>
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

                    if(isset($_POST['submit'])){
                        if ($_POST["ratingList"] == 0) {
                            echo "<p style =\"color:red;\">You must select a rating.</p>";
                        } else {
                            echo $_POST["ratingList"];
                            //set the button to disabled
                            buyerRated_set_to_true_for_auction($auction_bidded_on['auctionID']);


                        }
                    }



                } else {
                    echo "<td><span style=\"color:red\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></td>";
                    echo "<td>" ."Not applicable"  . "</td>";

                }

                echo "<tr>";
                $counter++;

            }
        }


        ?>



        <?php
        $my_bids_buyerID = retrieve_buyerID_from_loggedIn_userID($loggedIn_userID);
        $all_my_bids = retrieve_my_bids ($my_bids_buyerID);
        $counter=0;
        while ($my_bids = mysqli_fetch_assoc($all_my_bids)){


                while ($auction_bidded_on = mysqli_fetch_assoc($auction_bidded_on_set)) {

                    ?>
                    <script>
                        var <?php echo "t{$counter}"; ?> = <?php echo json_encode($auction_bidded_on["auctionEnd"]); ?>;

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

            }
        ?>


        </tbody>
    </table>
</div>


    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Your Website 2014</p>
            </div>
        </div>
        <!-- /.row -->
    </footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>

</html>
