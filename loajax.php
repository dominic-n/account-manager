<?php if(isset($_REQUEST['logi'])):?>
<label>Username:</label><input class = "box"type = "text" name = "user" /><br />
<label>Password:</label><input class = "box" type = "password" value = "" name = "password" /><br />
<label>Remember me next time</label><input type = "checkbox" name = "remember" /><br />
<button class = "edit" name = "login" id = "mdd" > Login </button> <br />
<?php 
if($_REQUEST['check'] == 0 && isset($_REQUEST['login']))
{
	echo "<b style='color:red;'>Sorry the username or password was wrong try again.</b>";
}

?>
<?php endif;?>
<?php if(isset($_REQUEST['sigup'])):?>
	<label>Username:</label><input class = "box"type = "text" name = "user" /><br />
<label>Password:</label><input class = "box" type = "password" value = "" name = "password" /><br />
<button class = "edit" name = "signup" id="ddm" > SignUp </button><br />
<?php endif;?>