<?php require_once("../includes/db_connection.php") ?>

<?php require_once("../includes/auction_functions.php"); ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>


<!-- refrerence http://www.w3schools.com/bootstrap/bootstrap_modal.asp -->
<div class="container">

    <?php


    $auctionID = 4000;
    $queryresult = mysqli_fetch_assoc(has_buyer_rated_this_auction($auctionID));
    echo htmlentities($queryresult['buyerRated']);

    if ($queryresult['buyerRated'] == 1){
        echo "Khello";
    }


    $roleID_set = mysqli_fetch_assoc(retrieve_seller_roleID_from_specified_auctionID($auctionID));

    $roleID=$roleID_set['roleID'];
    $rating_set=retrieve_rating_for_specified_role($roleID);
    $rating_for_role = mysqli_fetch_assoc($rating_set);
    echo htmlentities($rating_for_role['AVG(ratingValue)']);
    $rating_score = intval($rating_for_role['AVG(ratingValue)']);
    $whole_number_rating_score = round($rating_score);
    echo "<br />{$whole_number_rating_score}";
    $empty_stars= 5 - $whole_number_rating_score;
    echo "<br />{$empty_stars}";


    ?>



    <script>
        var counterOnTrack = <?php echo json_encode($counter); ?>;

        function myclicked(counterOnTrack) {

            document.getElementById(counterOnTrack).disabled=true;
        }

        function buttonID(theID) {
            var btnID = theID;
            alert("Button clicked " + btnID);

        }



    </script>

    <!--PHP file my_ajax_receiver.php-->
    <?php


    ?>

    <h2>Modal Example</h2>
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" id="tvaa" data-target="#myModal" onclick="buttonID(this.id)">Rate</button>

    <!-- Modal -->
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
                        <option value="4">4 -  Good</option>
                        <option value="5">5 -  Recommended</option>
                    </select></h4>
                </div>

                <div class="modal-footer">
                        <input id="submit" name="submit" type="submit" value="Submit">
                    </div>
                </form>

            </div>

        </div>
    </div>

</div>



</body>
</html>
