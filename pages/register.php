	<?php
        if (isset($_POST['register'])) {
            $username = mysql_real_escape_string($_POST['username']);
            $password = mysql_real_escape_string($_POST['password']);
            $cpassword = mysql_real_escape_string($_POST['cpassword']);
            $email = mysql_real_escape_string($_POST['email']);

            $ucheck = mysql_query("SELECT * FROM `accounts` WHERE `name`='" . $username . "'") or die(mysql_error());
            if ($username == "") {
                echo "<div class=\"error\">Please enter in a username.";
            } elseif (mysql_num_rows($ucheck) >= 1) {
                echo "Username is already being used.";
            } elseif ($password == "") {
                echo "Please enter in a password.";
            } elseif ($password != $cpassword) {
                echo "The passwords do not match.";
            } elseif ($email == "") {
                echo "Please enter in an email.";
            } elseif (strlen($username) < 4) {
                echo "Username must be between 4 and 12 characters!";
            } elseif (strlen($username) > 12) {
                echo "Username must be between 4 and 12 characters!";
            } elseif (strlen($password) < 6) {
                echo "Password must be between 6 and 12 characters!";
            } elseif (strlen($password) > 12) {
                echo "Password must be between 6 and 12 characters!";
			} else {
                $ia = mysql_query("INSERT INTO `accounts` (`name`,`password` ,`email`) VALUES ('" . $username . "','" . sha1($password) . "', '" . $email . "')") or die(mysql_error());
                echo "You are now registered to ".$servername."!";
            }
        }
    ?>
    <div id="body">
    <h1>Register</h1>
    <hr>
<form action="?page=register" method="POST" autocomplete="off" id="form">
	<input type="text" name="username" maxlength="12" required autocomplete="off" placeholder="Username" class="input"><br/>
	<input type="password" name="password" maxlength="30" required autocomplete="off" placeholder="Password" class="input"><br/>
	<input type="password" name="cpassword" maxlength="30" required autocomplete="off" placeholder="Verify Password" class="input"><br/>
	<input type="email" name="email" maxlength="50" required autocomplete="off" placeholder="Email" class="input"><br/><br/>
	<input type="submit" name="submit" value="Submit" class="registerbtn" style="margin-top: 5px;">
	<input type="hidden" name="register" value="1"/>
</form>
</div>