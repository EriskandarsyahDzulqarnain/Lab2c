<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Police Emergency Service System</title>
	<link rel="stylesheet" href="style.css">
</head>

<body bgcolor="#232222">
	
<script>
function eriskandarsyah()
{
	var x=document.forms ["frmLogCall"]["callerName"].value;
	if (x==null || x=="")
	{
		alert("Caller Name is required.");
		return false;
	}
    // may add code for validating other inputs
}
</script>
<?php require_once 'nav.php';?> <!--menu bar code -->
	
<?php require_once 'db.php'; //database details
//create database connection

$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);	
//check connection
if ($mysqli->connect_errno)	
{
	die ("Unable to connect to Database: ".$mysqli->connect_errno);
}

$sql = "SELECT * FROM incidentType";
	
if (!($stmt = $mysqli->prepare($sql)))
{
	die("Command error: ".$mysqli->errno);
}
	
if(!$stmt->execute())
{
	die("Cannot run SQL command".$stmt->errno);
}
	
if(!($resultset = $stmt->get_result()))
{
	die("No data in resultset: ".$stmt->errno);
}
	
	$incidentType; //an array variable
	
while ($row = $resultset->fetch_assoc())
{
	$incidentType[$row['incidenttypeid']] = $row['incidenttypedesc'];
}
	
$stmt->close();
	
$resultset->close();
	
$mysqli->close();
	
?>
	

<fieldset>
<form name="frmLogCall" method="post" action="dispatch.php"
onSubmit="return eriskandarsyah();" >

<table width="45%" border="1" align="center" cellpadding="4" cellspacing="4">
	
	<tr>
	<td width="50%" bgcolor="#E5E5E5">Caller's Name :</td>
	<td width="50%"><input type="text" name="callerName" id="callerName"></td>
	</tr>
	
	<tr>
	<td width="50%" bgcolor="#E5E5E5">Contact No :</td>
	<td width="50%"><input type="text" name="contactNo" id="contactNo"></td>
	</tr>
	 
	<tr>
	<td width="50%" bgcolor="#E5E5E5">Location :</td>
	<td width="50%"><input type="text" name="location" id="location"></td>
	</tr>
	
	<tr>
	<td width="50%" bgcolor="#E5E5E5">Incident Type :</td>
		<td width="50%"><select name="incidentType" id="incidentType">
	<?php 
			foreach( $incidentType as $key => $value){
	?>
			<option value="<?php echo $key ?>">
				<?php echo $value ?>
			</option>
				
	<?php
			}
	?>				
	</select>
	</td>
	</tr>
	
	<tr>
	<td width="50%" bgcolor="#E5E5E5">Description :</td>
		<td width="50%"><textarea name="incidentDesc" id="incidentDesc" cols="45" rows="5"></textarea></td>
	</tr>
	
	<tr>
	<td><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
	<td><input type="submit" name="btnProcessCall" id="btnProcessCall" value="Process Call"</td>
	</tr>
</table>
</form>
</fieldset>	

	


</body>
</html>
