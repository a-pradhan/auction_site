
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../css/1-col-portfolio.css" rel="stylesheet">

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
            <a class="navbar-brand" href="auction_list.php" onclick="MyFunction();">Auction Vault</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <div class="floatleft"></div>
                <li>

                    <a href="my_auctions.php"> Auctions</a>
                </li>
                <li>
                    <a href="my_bids.php">My Bids</a>
                </li>
                <li>
                    <a href="watch_list.php">Watch-list</a>
                </li>
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

    <script>
        function myAuctions() {
            document.getElementById("myAuctions").style.display = "block";
        }
        function myBids() {
            document.getElementById("myBids").style.display = "block";
        }

    </script>



    <!-- /.container -->
</nav>
