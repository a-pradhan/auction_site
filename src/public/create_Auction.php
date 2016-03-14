<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/general_functions.php"); ?>
<?php require_once("../includes/user.php"); ?>
<?php require_once("../includes/auction_functions.php"); ?>
<?php
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$loggedIn_userID = $_SESSION["userID"];

if (!isset($loggedIn_userID) && !attempt_login($username, $password)) {
    redirect_to("loginPage.php");
}
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
    <link href="../css/create_auctionStyling.css" rel="stylesheet"/>
    <link href="../css/bootstrap.min.css.map" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">



</head>
<body style="background-color: #dbdbdb">

<?php
// define variables and set to empty values
$itemName = "";
$itemQuantity = "";
$itemCategory = "";
$itemCondition = "";
$itemDescription = "";
$auctionName ="";
$startingPrice = "";
$auctionStartDate = "";
$auctionEndDate = "";
$itemNameErr = "";
$itemQuantityErr = "";
$itemCategoryErr = "";
$itemConditionErr = "";
$itemDescriptionErr = "";
$auctionNameErr = "";
$startingPriceErr = "";
$auctionStartDateErr = "";
$auctionEndDateErr = "";

$AllTrue = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["itemNameField"])) {
        $AllTrue = false;
        $itemNameErr = "Item Name is required";
    } else {
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $itemName)) {
            $itemNameErr = "Only letters and white space allowed";
        } else {
            $itemName = test_input($_POST["itemNameField"]);
        }
    }
    if (empty($_POST["itemQuantityField"])) {
        $itemQuantityErr = "Item quantity is required";
        $AllTrue = false;
    } else {
        $itemQuantity = test_input($_POST['itemQuantityField']);
    }
    if (empty($_POST["itemCategoryField"])) {
        $itemCategoryErr = "Item category is required";
        $AllTrue = false;
    } else {
        $itemCategory = test_input($_POST['itemCategoryField']);
    }

    if (empty($_POST["itemConditionField"])) {
        $itemConditionErr = "Item Condition cannot be empty";
        $AllTrue = false;
    } else {
        $itemCondition = test_input($_POST['itemConditionField']);
    }

    if (empty($_POST["itemDescriptionField"])) {
        $itemDescriptionErr = "Item Description cannot be empty";
        $AllTrue = false;
    } else {
        $itemDescription = test_input($_POST['itemDescriptionField']);
    }
//    if (empty($_POST["auctionNameField"])) {
//        $auctionNameErr = "Auction Name cannot be empty";
//        $AllTrue = false;
//    } else {
//        $itemDescription = test_input($_POST['itemDescriptionField']);
//    }
    if (empty($_POST["startingPriceField"])) {
        $startingPriceErr = "Starting Price cannot be empty";
        $AllTrue = false;
    } else {
        $startingPrice = test_input($_POST['startingPriceField']);
    }
    if (empty($_POST["AuctionStartDateField"])) {
        $auctionStartDateErr = "Auction Start Date cannot be empty";
        $AllTrue = false;
    } else {
        $auctionStartDate = test_input($_POST['AuctionStartDateField']);
    }
    if (empty($_POST["AuctionEndDateField"])) {
        $auctionEndDateErr = "Auction End Date cannot be empty";
        $AllTrue = false;
    } else {
        $auctionEndDate = test_input($_POST['AuctionEndDateField']);
    }

    if ($AllTrue === true) {


        $roleID = retrieve_sellerID_from_loggedIn_userID($loggedIn_userID);
        //Item Info
        $query = "INSERT INTO Item (";
        $query .= "itemName, itemQuantity, itemCategory, itemDescription, itemCondition, roleID";
        $query .= ") VALUES (";
        $query .= "'{$itemName}', {$itemQuantity}, '{$itemCategory}', '{$itemDescription}','{$itemCondition}',{$roleID}";
        $query .= ")";
        $result = mysqli_query($connection, $query);

        $itemId = mysqli_insert_id($connection);


        //Auction Info
        $query2 = "INSERT INTO Auction (";
        $query2 .= "auctionReservePrice, auctionStart, auctionEnd, itemId";
        $query2 .= ") VALUES (";
        $query2 .= "{$startingPrice}, '{$auctionStartDate}', '{$auctionEndDate}',{$itemId} ";
        $query2 .= ")";
        $result2 = mysqli_query($connection, $query2);


        if (isset($_FILES['image'])) {
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

            $extensions = array("jpeg", "jpg", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }

//    if($file_size > 209715200){
//        $errors[]='File size must be excately 2 MB';
//    }
            $newImageName = $itemId . "." . $file_ext;
            if (empty($errors) == true) {
                move_uploaded_file($file_tmp, "../itemImages/" . $newImageName);
                $query4 = "UPDATE Item SET itemPhoto='{$newImageName}' WHERE itemID = {$itemId} ";
                $result4 = mysqli_query($connection, $query4);

                echo "Success";
                header("Location: my_auctions.php");
            } else {
                print_r($errors);

            }

        }
    }
}

//$itemId = mysqli_insert_id($connection);
//}
//after make insert item query
//follow up with

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;


}

?>
<?php include("../includes/layouts/navbar.php") ?>

<!-- Page Content -->
<div class="container">

    <div class="col-sm-12">
        <!-- Page Heading -->
        <div class="row"> <!--WHOLE PAGE -->
            <div class="col-md-12">
                <h2 class="page-header">Create Auction
                    <small>Money motivation</small>
                </h2>
            </div>
        </div>
        <!-- Search and filtering -->
        <form class="form" method="post" name="createAuctionForm" action="create_Auction.php"
              enctype="multipart/form-data">

            <div class="row panel panel-default panel-shadow">
                <div class="col-sm-12">
                    <h2>Item info</h2>
                    <hr>
                </div>
                <div class="col-sm-6">
                    <h4>Item Name</h4>
                    <input class="input-sm" name="itemNameField" value="<?php echo($_POST['itemNameField']) ?>"
                           style="width: 300px">
                    <span class="error"><?php echo $itemNameErr ?></span>
                    <h4>Quantity</h4>
                    <input class="input-sm" name="itemQuantityField"
                           value="<?php echo($_POST['itemQuantityField']) ?>">
                    <span class="error"><?php echo $itemQuantityErr ?></span>
                    <h4>Item Category</h4>

                    <select name="itemCategoryField" value="<?php echo($_POST['itemCategoryField']) ?>">
                        <option value=""></option>
                        <option value="Car">Car</option>
                        <option value="Mobile Phone">Mobile Phones</option>
                        <option value="Laptop">Laptops</option>
                        <option value="Bike">Bike</option>
                        <option value="Jewellry">Jewellry</option>
                        <option value="Miscellaneous">Miscellaneous</option>
                    </select>
                    <span class="error"><?php echo $itemCategoryErr ?></span>
                    <h4>Item Condition</h4>
                    <select name="itemConditionField" value="<?php echo($_POST['itemConditionField']) ?>">
                        <option value=""></option>
                        <option value="Used">Used</option>
                        <option value="Used - Like New">Used - Like New</option>
                        <option value="New">New</option>
                    </select>
                    <span class="error"><?php echo $itemConditionErr ?></span>
                </div>
                <div class="col-sm-6">
                    <h4>Item Description</h4>
                        <textarea class="itemDescription"
                                  name="itemDescriptionField"><?php echo($_POST['itemDescriptionField']) ?></textarea>
                    <span class="error"><?php echo $itemDescriptionErr ?></span>
                </div>

            </div>

            <hr>
            <div class="row panel panel-default panel-shadow" style="padding: 20px">
                <div class="col-sm-12">
                    <h2>Auction info</h2>
                    <hr>
                </div>
                <div class="col-sm-6">
<!--                    <h4>Acution Name</h4>-->
<!--                    <input class="input-sm" name="auctionNameField" width="300px"-->
<!--                           value="--><?php //echo($_POST['auctionNameField']) ?><!--">-->
<!--                    <span class="error">--><?php //echo $auctionNameErr ?><!--</span>-->
                    <h4>Reserve Price</h4>
                    <input class="input-sm" name="startingPriceField"
                           value="<?php echo($_POST['startingPriceField']) ?>">
                    <span class="error"><?php echo $startingPriceErr ?></span>
                    <h4>Auction Start Date</h4>
                    <input type="text" class="datetimepicker" name="AuctionStartDateField"
                           value="<?php echo($_POST['AuctionStartDateField']) ?>">
                        <span class="warning"
                              value="<?php echo $auctionStartDateErr ?>"><?php echo $auctionStartDateErr ?></span>


                    <h4>Auction End Date</h4>
                    <input type="datetime" class="datetimepicker" name="AuctionEndDateField"
                           value="<?php echo($_POST['AuctionEndDateField']) ?>">
                    <span class="error"><?php echo $auctionEndDateErr ?></span>

                    <br/>
                </div>
                <div class="col-sm-6">
                    <!--http://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded -->
                    <img id="blah" alt="your image" class="img-responsive center-block" style="padding: 20px"
                         width="50%" height="50%"/>
                    <p>
                        <input type="file" name="image"
                               onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"/>

                </div>
                <div class="col-sm-12 text-center" style="padding-top: 20px">
                    <button class="btn-gold form-control" type="submit" name="submitAuction">Submit Auction
                    </button>
                </div>
            </div>
        </form>


        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <p>Copyright &copy; Team 40 Money Motivation</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>


        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>
    </div>
</div>

</body>
<script src="../js/jquery.js"></script>
<script src="../js/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
    $('.datetimepicker').datetimepicker({format: "Y-m-d h:m:s"});

    $(function () {
        $(".datetimepicker").on("change", function () {
            var selected = $(this).val();

            //alert(selected);
        });
    });


</script>
</html>

