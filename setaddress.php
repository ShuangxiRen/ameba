<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae set address</title>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family:Arial, Sans-serif;}
a {text-decoration:none;}
a.pagename {
  padding:3px;
  font-weight:bold;
  font-family:serif;
  letter-spacing:-3px;
  font-size:55px;
  color:#111;
}
input[type=text], input[type=password] {
  display:inline-block;
  width:100%;
  padding:8px 0;/*very important keep input field center*/
  border:1px solid #aaa;
  border-radius:3px;
  border-sizing:border-box;
}
input[type=submit] {
  display:inline-block;
  width:100%;
  padding:10px 18px;
  border:none;
  border-radius:3px;
  background-color:#4CAF50;
  color:white;
  cursor:pointer;
}
input[type=submit]:hover {
  background-color:#45A049;
}
div {
  width:300px;
  padding:0px 15px;
  margin:auto;/*keep it center of the page*/
  border:1px solid #ccc;
  border-radius:3px;
}
span.label{
  font-size:14px;
  font-weight:bold;
}
span.error {
  font-size:13px;
  color:red;
}
</style>
</head> 

<body>
<?php
if(!$_SESSION['uname'] || !$_SESSION['uid'])
{
  echo'<span style="font-size:20pt;color:red">Please sign in!</span><br/><br/>';
  echo'<a href="index.php" style="font-size:25pt;color:blue;text-decoration:none">Go to homepage</a><br/>';
  exit();
}
$vusername = $_SESSION['uname'];
$vuserid = $_SESSION['uid'];
include "dbconnect2.php";
?>
<p style="text-align:center">
<a class="pagename" href="index.php">amabae</a>
<p>
<div>
<p style="text-align:center; font-size:28px;">Set address</p>

<?php
$vstate = $vcity = $vstreet = $vzip = "";
$fstateErr = $fcityErr = $fstreetErr = $fzipErr = "";
$inputok = true;
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(empty($_POST['fstreet'])){
    $fstreetErr = "Street is required";
	$inputok = false;
  }else{
    $vstreet = clean_input($_POST['fstreet']);
  }
  if(empty($_POST['fcity'])){
    $fcityErr = "City is required";
	$inputok = false;
  }else{
    $vcity = clean_input($_POST['fcity']);
  }
  if(empty($_POST['fstate'])){
    $fstateErr = "State is required";
	$inputok = false;
  }else{
    $vstate = clean_input($_POST['fstate']);
  }
  if(empty($_POST['fzip'])){
    $fzipErr = "ZIP is required";
	$inputok = false;
  }else{
    $vzip = clean_input($_POST['fzip']);
	if(!preg_match("/^[0-9-,]+$/", $vzip)){
	  $fzipErr = "only number and , - are allowed";
	  $inputok = false;
	}
  }
  if($inputok == true){//now begin to delete old and insert new address in database
    if(!$query = mysqli_query($conn, "delete from Address where UserID = '$vuserid'")){
	  echo "delete old address failed";
	  mysqli_close($conn);
	  exit();
	}
	$prestmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($prestmt, "insert into Address(UserID, state, city, street, zip) values(?, ?, ?, ?, ?)")){
	  echo "SQL prepare error";
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	  exit();
	}
	mysqli_stmt_bind_param($prestmt, "sssss", $vuserid, $vstate, $vcity, $vstreet, $vzip);
	if(!mysqli_stmt_execute($prestmt)){
	  echo "insert new address failed";
	  mysqli_close($conn);
	  exit();
	}else{
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	  echo '<script>
	  alert("Set address successfully!");
	  window.location.href = "userinfo.php";
	  </script>';
	  //header("Location:userinfo.php");
	}
  }
}
function clean_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
<span class="label">Street:&nbsp&nbsp</span><span class="error"><?php echo $fstreetErr; ?></span><br>
<input type="text" name="fstreet" value="<?php echo $vstreet; ?>">
<br/>
<br/>
<span class="label">City:&nbsp&nbsp</span><span class="error"><?php echo $fcityErr; ?></span><br>
<input type="text" name="fcity" value="<?php echo $vcity; ?>">
<br/>
<br/>
<span class="label">State:&nbsp&nbsp</span><span class="error"><?php echo $fstateErr; ?></span><br>
<input type="text" name="fstate" value="<?php echo $vstate; ?>">
<br/>
<br/>
<span class="label">ZIP:&nbsp&nbsp</span><span class="error"><?php echo $fzipErr; ?></span><br>
<input type="text" name="fzip" placeholder="Only numbers and - and , allowed" value="<?php echo $vzip; ?>">
<br/>
<br/>
<input type="submit"  value="Set address" /></br>
</form>
<p style="text-align:center;font-size:14px;color:#888">
<a style="color:blue;" href="userinfo.php">Go back</a></p>
</div>
</body>
</html> 
