<!-- Navigation bar-->
<nav class="navbar navbar-gold navbar-fixed-top" role="navigation" style="box-shadow: 0px 0px 10px #606060">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="auction_list.php"><img class="navbar-brand" src="../../images/logo2.png" style="padding: 4px"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-gold-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="my_auctions.php">My Auctions</a>
                </li>
                <li>
                    <a href="auction_list.php">Live Auctions</a>
                </li>
                <li>
                    <a href="my_bids.php">My Bids</a>
                </li>
                <li>
                    <a href="create_Auction.php">Create Auction</a>
                </li>
                <li>
                    <a href="watch_list.php">My Watchlist</a>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a> Logged in as  <?php echo $username?> </a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>