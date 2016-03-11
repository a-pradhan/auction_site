
    <style>
        body{
            text-align: center;
        }

        input{
            margin-top:20px;
            font-size:16px;
            font-weight: bold;
            padding:5px 10px;
        }

        #box{
            margin:50px auto;
            width:500px;
            height:100px;
            color:#fff;
            padding:10px;
            background: orange;
        }

    </style>


<input type="button" value="Hide Box" class="button-hide" />
<input type="button" value="Show Box" class="button-show"  />

<div id="box">Box</div>

<!--
    We use Google's CDN to serve the jQuery js libs.
    To speed up the page load we put these scripts at the bottom of the page
-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>

    //DOM loaded
    $(document).ready(function() {

        //attach click event to buttons
        $('.button-show').click(function(){

            /**
             * when show button is clicked we call the show plugin
             * which scales the box to default size
             * You can try other effects from here: http://jqueryui.com/effect/
             */
            $("#box").show("scale", 500);

        });

        $('.button-hide').click(function(){

            //same thing happens except in this case we hide the element
            $("#box").hide("scale", 500);

        });
    });



</script>

