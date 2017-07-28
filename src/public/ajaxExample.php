
<html>

<head>
    <title>The jQuery Example</title>
    <script type = "text/javascript"
            src = "http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type = "text/javascript" language = "javascript">


        var onTrack = "4000";


        function buttonID(theID){
            btnID=theID;
            alert("Khello " + btnID);
            $.post(
                "ajaxExample.php",
                { name:  onTrack},
                function(data) {
                    $('#stage').html(data);
                }
            );

        }


    </script>
</head>
<?php


    $name = $_POST['name'];
    echo "Khello Again<br />";
    echo "Welcome ". $name;


?>



<body>

<p>Click on the button to load result.html file −</p>

<p id = "stage" ></p>

<input type = "button" id = "driver" value = "Load Data" onclick="buttonID(this.id)";" />

</body>

</html>