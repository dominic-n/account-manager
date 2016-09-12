<?php session_start();?>
	<?php 
	
	date_default_timezone_set("Africa/Nairobi");
	$myfile = fopen("set", "r") or die("Some settings seems to be corrupted contact admin.!<br />");
$det= fgets($myfile);
fclose($myfile);
$det = explode(",",$det);
$conn = mysqli_connect("localhost",$det[0],$det[1],"money");
//Delete.

	if(isset($_REQUEST['deleterow']))
{
	$row = $_REQUEST['deleterow'];
	$rows = explode(",",$row);
	for ($j = 0; $j<count($rows); $j++)
	{
		$current = $rows[$j];
	$sql = "Delete from ". $_REQUEST['table']." where id = ".$current;
	if($conn->query($sql) === TRUE)
	{
		//rearrange the ids.

	}
	else 
	{
		echo "Database connection error.".$conn->error;
	}
	
	}
	//End of loop
	//Rearrange ids.
	$sql = "SELECT * from ".$_REQUEST["table"];
	$all = $conn->query($sql);
	$prev = 0;
	if($all->num_rows >0)
	{
		while ($ind = $all->fetch_assoc())
		{
			$id = $ind["id"];
             $sql= "UPDATE ".$_REQUEST["table"]." SET id =".($prev+1)." WHERE id = ".$id;
             $conn->query($sql);
             $prev = $prev+1;
		}
	}
	
	
}
//Delete
?>
	
	<?php 
	//?EDit.
	if(isset($_REQUEST["value"]))
	{
		$ids = explode(",",$_REQUEST["id"]);
		$values = explode(",",$_REQUEST["value"]);
		for ($j = 0; $j<count($ids); $j++)
	{
		
			$cvalue = explode("?",$values[$j]);
				$sql = "UPDATE ".$_REQUEST["fr"]." SET amount = '".$cvalue[2]."', description =  '".$cvalue[3]."' WHERE id = ".$ids[$j];
				//echo $sql."<br />";
		if($conn->query($sql) === TRUE)
	{
		//echo "Update succesful.<br />";
	}
	else 
	{
		echo "Database connection error. Could not update.<br />".$conn->error;
	}
	
	}
	}
	?>
	
	<?php
	if(isset($_POST["amount"]))
{
	$amt = $_POST["amount"];$des = $_POST["description"];$dat = date("Y-m-d H:i:s");$tab = $_POST["fr"];
	$sql = "INSERT INTO ".$tab." (date,amount,description) VALUES ('$dat','$amt','$des')";


	if($conn->query($sql) === TRUE)
	{
		//echo "Data inputted succefully.<br />";
	}
	else
	{
		//echo ($conn->error);
		echo "<b style='color:red;'>Data Could not be inputted succefully, contact adminstrator.</b><br />";
	}
}
	?>
	
	<?php
	//Normal execution.
		$sql = "SELECT * from ".$_REQUEST["fr"];
	$all = $conn->query($sql);
	if($all->num_rows >0)
	{?>
	<span class = "right"><?php 
if($_SESSION['edit'] == "true"):
?><button class = "edit" id = "Edit">Edit</button>
		<button class = "edit" id = "delete" >Delete</button>
		<?php endif;?>
		</span>
		<div id="table">
		<?php echo '<table style = "border:1px solid black;" id = "display"> <tr><th>ID</th><th>DATE</th><th>Amount</th><th>DESCRIPTION</th><th></th></tr>';
		$total=0;
		while($ind = $all->fetch_assoc())
		{
			echo'<tr id = "row'.$ind["id"].'"><td>'.$ind["id"].'</td><td>'.
			($ind["date"])
			.'</td><td>'.$ind["amount"].
			'</td><td>'.$ind["description"].'</td><td ';
			
			echo '><input type = "checkbox" class = "row'.$ind["id"].'" /></td></tr>';
			$total+=$ind["amount"];
		}
		echo'<tr id = "row'.$ind["id"].'"><td>Total</td><td></td><td>'.$total.
			'</td><td></td><td ';
			
			echo '></td></tr>';
		echo '</table>';
	}
	?>
	</div>