<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>update</title>
</head>

<body>
<?php require_once 'nav.php'; ?>
<br><br>
<?php
if(!isset($_POST["btnSearch"])){
?>
<form name="form1" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?> ">
  <table width="50%" border="0" align="center" cellpadding="4" cellspacing="4">
      <tr></tr>
    <tr>
      <td>Patrol Car ID :</td>
      <td><input type="text" name="patrolcarId" id="patrolcarId"></td>
      <td><input type="submit" name="btnSearch" id="btnSearch" value="Search"></td>
    </tr>
   </table>
</form>
  
<?php }
  
else
{
  require_once 'db.php';
  
  $mysqli= mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
  if($mysqli->connect_errno) {
     die("Failed to connect MYSQL:".$mysqli->connect_errno);
  }
  
  $sql="SELECT* FROM patrolcar WHERE patrolcarId = ?";
  
  if(!($stmt = $mysqli->prepare($sql))){
     die("Prepare failed: ".$mysqli->errno);
  }
  
  if(!$stmt->bind_param('s', $_POST['patrolcarId'])){
     die("Binding parameters failed: ".$stmt->errno);
  }
  
  if(!$stmt->execute()){
    die("Execute failed failed: ".$stmt->errno);
  
  }
  
  if(!($resultset = $stmt->get_result())) {
     die("Getting result set failed: ".$stmt->errno);
  }
  
  if ($resultset->num_rows == 0){
    ?>
  
         <script>window.location="update.php";</script>
       <?php }
  
  $patrolCarId;
  $patrolCarStatusId;
  
  while ($row = $resultset->fetch_assoc()) {
    $patrolCarId=$row['patrolcarId'];
    $patrolCarStatusId =$row['patrolcarStatusId'];
  }
  
  $sql="SELECT * FROM patrolcar_status";
  if(!($stmt = $mysqli->prepare($sql))) {
     die("Prepare failed:".$mysqli->errno);
  }
  
  if(!$stmt->execute()) {
    die("Execute failed:".$stmt->errno);
  }
  
  if(!($resultset = $stmt->get_result())) {
     die("Getting result set failed:".$stmt->errno);
  }
     
  $patrolCarStatusArray;;
  
  while($row =$resultset->fetch_assoc()) {
    $patrolCarStatusArray[$row['statusId']] = $row['statusDesc'];
  }
  
  $stmt->close();
  
  $resultset->close();
  
  $mysqli->close();
?>

<form name="form2" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?> ">
  
   <table width="50%" border="0" align"center" cellpadding="4" cellspacing="4">
     <tr></tr>
     <tr>
       <td>ID :</td>
       <td><?php echo $patrolCarId ?>
         <input type="hidden" name="patrolCarId" id="patrolCarId"
           value="<?php echo $patrolCarId ?>">
        </td>
      </tr>  
      <tr>
          <td>Status :</td>
            <td><select name="patrolCarStatus" id="patrolCarStatus">
                  <?php foreach($patrolCarStatusArray as $key => $value){ ?>
              <option value="<?php echo $key ?>"
                 <?php if ($key==$patrolCarStatusId) {?> selected="selected"
                 <?php }?>
                >
            <?php echo $value ?>
          </option>
          <?php } ?>                           
          </select></td>
            </tr>
          <tr>
        <td><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
          type="submit" name="btnUpdate" id="btnUpdate" value="Update">
        </td>
    </tr>
   </table>
</form>
<?php } ?>
</body>
</html>