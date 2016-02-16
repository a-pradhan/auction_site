<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/02/16
 * Time: 16:35
 */

// establish database connection - move to includes function later on


?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>

<div class="formContainer">
    <h2 class="formHeader">Please enter your details</h2>
    <form class="signupForm" action="create_subject.php" method="post">
        <div>
            <h3>Email Address</h3>
            <input type="text" name="email_address" value=""/>
        </div>
       <div>
           <h3>Username</h3>
           <input type="text" name="username" value=""/>
       </div>
        <div>
            <h3>Password</h3>
            <input type="text" name="password" value=""/>
        </div>
        <div>
            <h3>Confirm Password</h3>
            <input type="text" name="password_confirmation" value=""/>
        </div>
        <div>
            <input type="submit" name="submit" value="Sign Up"/>
        </div>

    </form>


</div>
</body>
</html>
