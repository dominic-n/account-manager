<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<title>:Finance Manager App</title>
<link rel="icon" href="favicon.ico">
<?php
date_default_timezone_set("Africa/Nairobi");
if(!file_exists('set'))
{
	die('<meta http-equiv="refresh" content=".1; url=./config.php" />');
}
	
$myfile = fopen("set", "r") or die("Some settings seems to be corrupted contact admin.!<br />");
$det= fgets($myfile);
fclose($myfile);
$det = explode(",",$det);
if(count($det)==1)$fr="";else$fr=$det[1];
$conn = mysqli_connect("localhost",$det[0],$fr,"money");
if(!isset($_SESSION['user']))
{
	die('<meta http-equiv="refresh" content=".1; url=./login.php" />');
}
?>
<link href="./css/font-awesome.min.css" rel="stylesheet"/>
<link href="./style.css" rel ="stylesheet"/>
<script src="./jquery-1.12.3.min.js"></script>
<script src="./script.js"></script>
<script>
	<?php 
	if($_SESSION['edit'] == 'true'):
	?>
	$(document).on('click','#display td', function (){
		if(!$(this).children("input").length){
			$(this).css("color","green");
		$(this).attr("contenteditable","true");
		}
	});
	<?php endif; ?>
</script>
</head>
<body style="">
<main>
<div id = "selec">
<div id = "selecin" class = "selch" ><span style="color:black">Income:</span><input type = "radio"  name = "tab" value = "income"  checked/></div>
<div id = "selecout"><span style="color:black">outcome:</span><input  type = "radio" name = "tab"  value = "outcome"/></div>
<div id = "detail">
<i class = "fa fa-user"></i>
<?php
echo $_SESSION['user'].":";
?>
<i class = "fa pwer fa-power-off"></i>
</div>
</div>
<?php 
if($_SESSION['edit'] == "true"):
?>
<h1>recording panel:</h1>
<p id = "update">
	<div style="margin-top:6px">
		
		<span class = "middle">Amount:</span><input class = "inline box" name = "amount" type = "number"placeholder = ""/>
		<span class = "middle">Description:</span><textarea  placeholder = "" name = "description"></textarea>
		<button class = "edit" id="buttonupdate" name = "insubmit">Update</button>
	</div>
</p>

<?php endif;?>

<p id = "output">

</p>
</main>
</body>
</html>
