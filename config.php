<?php session_start();?>
<!DOCTYPE html>
<html>
<head>

<link href="./style.css" rel ="stylesheet"/>
<script src="./jquery-1.12.3.min.js"></script>
<script>
	$(document).ready(function (){
		$("#config").click(function (){
			if(!$("input[name=dbuser]").val()||!$("input[name=usern]").val()||!$("input[name=passw]").val())
			{
				alert("Cannot be left empty.");
				event.preventDefault();
			}
		});
	});
</script>
</head>
<body style="background:url(img.jpg);">
<main>
<div id = "selec">
<div id = "selecin" class = "selch" style="color: rgb(51, 102, 0);"><span>Configuration:\<</span></div>
</div>
<br />
<br />
<p id = "output">
<?php
date_default_timezone_set("Africa/Nairobi");
if(!file_exists('set'))
{

?>
<form method="post">
<h3>User information.(Admin)</h3>
<label>Username:</label><input class = "box" type = "text" name = 'usern' /><br />
<label>Password:</label><input class = "box" type ="password" name = 'passw' /><br />
<h3>DataBase Access information.</h3>
<label>Username:</label><input class = "box" type = "text" name = 'dbuser' /><br />
<label>Password:</label><input class = "box" type ="password" name = 'dbpass' /><br />

<input type= "submit" id = "config" class = "edit" value="Config"/>
</form>
<?php
if(isset($_REQUEST["dbuser"]))
{
	$d = 1;
	$conn = mysqli_connect("localhost",$_REQUEST["dbuser"],$_REQUEST["dbpass"]) or 
	die("Error connecting to database.".$conn->error."<br />");

$myfile = fopen("set", "w") or die("Could not setup, Contact Admin.<br />");
$txt = $_REQUEST['dbuser'];
if($_REQUEST['dbpass'])
$txt .= ",".$_REQUEST['dbpass'];
fwrite($myfile, $txt);
fclose($myfile);


$sql = "CREATE DATABASE money";
$conn->query($sql) or die ("Error creating database: " . $conn->error."<br />");
$conn = mysqli_connect("localhost",$_REQUEST["dbuser"],$_REQUEST["dbpass"],"money");
$sql = "CREATE TABLE income (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
date DATETIME NOT NULL,
amount INT NOT NULL,
description MEDIUMTEXT
)";
$conn->query($sql) or die ("Income table could not be created.".$conn->error. "<br />");
$sql = "CREATE TABLE outcome (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
date DATETIME NOT NULL,
amount INT NOT NULL,
description MEDIUMTEXT
)";
$conn->query($sql) or die ("Outcome table could not be created.".$conn->error. "<br />");
$sql = "CREATE TABLE monuser (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
usern VARCHAR(50),
passw VARCHAR(50),
edit VARCHAR(50)
)";
$conn->query($sql) or die ("User table could not be created.".$conn->error. "<br />");
if($_REQUEST["usern"] != "" && $_REQUEST["passw"] !== "")
{
	$sql = "INSERT into monuser (usern,passw,edit) VALUES ('".$_REQUEST['usern']."','".$_REQUEST['passw']."','true')";
	$conn->query($sql) or die ("Couldnot Enter the dadmin details into database..".$conn->error. "<br />");
			$_SESSION['user'] = $_REQUEST['usern'];
			$_SESSION['passw'] = $_REQUEST['passw'];
			$_SESSION['edit'] = "true";
}
echo "<h3>Setup compeleted succesfully.</h3><a href = '/account.php'>proceed to main page.</a><br />Alternatively proceed to <a href = '/setting.php'>Settings page</a> to select your preferences.<br />";
 }
}
else
//File exists.
{
$myfile = fopen("set", "r") or die("Some settings seems to be corrupted contact admin.!<br />");
$det= fgets($myfile);
fclose($myfile);
$det = explode(",",$det);
//echo($det[0]." ".$det[1]." ?");

if(count($det)==1)$fr="";else$fr=$det[1];
$conn = mysqli_connect("localhost",$det[0],$fr,"money");


?>
<h3>Configuration is already finished.Enjoy.</h3>
<a href = '/account.php'>proceed to main page.</a><br />Alternatively proceed to <a href = '/setting.php'>Settings page</a> to select your preferences.<br />
<?php
} 

?>
</p>
</main>
</body>
</html>