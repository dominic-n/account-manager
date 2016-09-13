<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<title>App Login</title>
<?php
if(!file_exists('set'))
{
	//die("<meta http-equiv='refresh content='0; url=/config.php' />");
	die('<meta http-equiv="refresh" content=".1; url=./config.php" />');
}
$myfile = fopen("set", "r") or die("Some settings seems to be corrupted contact admin.!<br />");
$det= fgets($myfile);
fclose($myfile);
$det = explode(",",$det);
//if(count($det)==1)$fr="";else$fr=$det[1];
$conn = mysqli_connect("localhost",$det[0],$det[1],"money") or die("localhost,".$det[0].",".$det[1].",money Could nt connect".$conn->error);$check = 0;
if(isset($_REQUEST['logout']))
{
	session_destroy();
}
if(isset($_REQUEST['login']))
{
	if($_REQUEST['login'] == "login"){
		
	
	$sql = "SELECT * from monuser";
	$all = $conn->query($sql);
	if($all->num_rows >0){
		
	
	while($ind = $all->fetch_assoc())
	{
		
		if($ind['usern'] === $_REQUEST['user'] && $ind['passw'] === $_REQUEST['password'])
		{
			$check = 1;
			$_SESSION['user'] = $_REQUEST['user'];
			$_SESSION['passw'] = $_REQUEST['password'];
			$_SESSION['edit'] = $ind['edit'];
			die ("<meta http-equiv='refresh' content='.1; url=./account.php' />");	
		}
	}
	}
	}
	else if($_REQUEST['login'] == "signup")
	{
		
	
	$sql = "SELECT * from monuser";
	$all = $conn->query($sql);
	$none = 1;
	if($all->num_rows >0):
	while($ind = $all->fetch_assoc())
	{
		
		if($ind['usern'] === $_REQUEST['user'] && md5($ind['passw']) === $_REQUEST['password'])
		{
			$none = 0;
			$_SESSION['user'] = $_REQUEST['user'];
			$_SESSION['passw'] = $_REQUEST['password'];
			$_SESSION['edit'] = $ind['edit'];
			die ("<meta http-equiv='refresh' content='.1; url=./account.php' />");	
		}
	}
	endif;
		if($none == 1)
	{
			$sql = "INSERT INTO monuser (usern,passw,edit) VALUES ('".$_REQUEST['user']."','".$_REQUEST['password']."','false')";
			$conn->query($sql) or die ("Could not Enter details into database..".$conn->error. "<br />");
			$_SESSION['user'] = $_REQUEST['user'];
			$_SESSION['passw'] = md5($_REQUEST['password']);
			$_SESSION['edit'] = 'false';
			die ("<meta http-equiv='refresh' content='.1; url=./account.php' />");
	}
	}
}

?>
<link href="/style.css" rel ="stylesheet"/>
<script src="/jquery-1.12.3.min.js"></script>
<script>
	$(document).ready(function (){
		$('#log').click(function (){
			var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
				    if (xhttp.readyState == 4 && xhttp.status == 200) {
     	document.getElementById("output").innerHTML = xhttp.responseText;
    	}
  		};
  		xhttp.open("POST", "loajax.php", true);
  		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("logi='logi'&check="+<?php echo $check;?>);
		});
		$('#sign').click(function (){
			var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
				    if (xhttp.readyState == 4 && xhttp.status == 200) {
     	document.getElementById("output").innerHTML = xhttp.responseText;
    	}
  		};
  		xhttp.open("POST", "loajax.php", true);
  		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("sigup='logi'");
		});
		//Login:
		$(document).on('click','#mdd',function (){
			if(!$("input[name='user']")||!$("input[name='password']"))
			{
				alert("fill in the file.");
				return 0;
			}
			else
			{
			var fr = $('<form method = "POST" ></form>');
			$("body").append(fr);
			
			var user =$("input[name=user]").val();
			var password = $("input[name=password]").val();
			fr.append('<input type = "hidden" name="user" value = "'+user+'"/><input type = "hidden" name="password" value = "'+password+'"/><input type = "hidden" name="login" value = "login"/>');
			fr.submit();
			}
	       });
	       //Signup:
		$(document).on('click','#ddm',function (){
			if(!$("input[name=user]")||!$("input[name=password]"))
			{
				alert("fill in the file.");
				return 0;
			}
			else
			{
			var fr = $('<form method = "POST" ></form>');
			$("body").append(fr);
			var user =$("input[name=user]").val();
			var password = $("input[name=password]").val();
			fr.append('<input type = "hidden" name="user" value = "'+user+'"/>'+
			'<input type = "hidden" name="password" value = "'+password+'"/>'+
			'<input type = "hidden" name="login" value = "signup"/>');
			fr.submit();
			}
	       });
		//Initial:
		var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
				    if (xhttp.readyState == 4 && xhttp.status == 200) {
     	document.getElementById("output").innerHTML = xhttp.responseText;
    	}
  		};
  		xhttp.open("POST", "loajax.php", true);
  		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  		xhttp.send("logi='logi'&check="+<?php echo $check;?>);
	});
</script>
</head>
<body style="background:url(img.jpg);">
<main>
<div id = "selec">
<div id = "selecin" class = "selch" style="color: rgb(51, 102, 0);"><span id = "log">Login:\<</span></div><div id = "selecin" class = "selch" style="color: rgb(51, 102, 0);"><span id = "sign">SignUp:\<</span></div>
</div>
<br />
<br />

<p id = "output">

</p>
</main>
</body>
</html><?php

?>
