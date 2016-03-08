<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Increment count when button is clicked</title>
</head>

<body>



<input id="myText" type="text" onkeyup="stoppedTyping()">
<input type="button" value="Click to begin!" id="start_button" onclick="verify()" disabled/>

<script type="text/javascript">
    function stoppedTyping(){
        if(this.value.length > 0) {
            document.getElementById('start_button').disabled = false;
        } else {
            document.getElementById('start_button').disabled = true;
        }
    }
    function verify(){
        if myText is empty{
            alert "Put some text in there!"
            return
        }
    else{
            do button functionality
        }
    }
</script>
</body>
</html>