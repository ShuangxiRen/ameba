<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae set phone</title>
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
<p style="text-align:center; font-size:28px;">Set phone</p>

<?php
$vphone = "";
$fphoneErr = "";
$inputok = true;
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(empty($_POST['fphone'])){
    $fphoneErr = "phone is required";
	$inputok = false;
  }else{
    $vphone = clean_input($_POST['fphone']);
	if(!preg_match("/^[0-9-]+$/", $vphone)){
	  $fphoneErr = "Only numbers and - allowed";
	  $inputok = false;
	}
  }
  if($inputok == true){//now begin to delete old and insert new address in database
    if(!$query = mysqli_query($conn, "delete from Phone where UserID = '$vuserid'")){
	  echo "delete old address failed";
	  mysqli_close($conn);
	  exit();
	}
	$prestmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($prestmt, "insert into Phone(UserID, phonenumber) values(?, ?)")){
	  echo "SQL prepare error";
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	  exit();
	}
	mysqli_stmt_bind_param($prestmt, "ss", $vuserid, $vphone);
	if(!mysqli_stmt_execute($prestmt)){
	  echo "insert new phone failed";
	  mysqli_close($conn);
	  exit();
	}else{
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	  echo '<script>
	  alert("Set phone successfully!");
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
<span class="label">Phone:&nbsp&nbsp</span><span class="error"><?php echo $fphoneErr; ?></span><br>
<input type="text" name="fphone" placeholder="Only numbers and - allowed" value="<?php echo $vphone; ?>">
<br/>
<br/>
<input type="submit"  value="Set phone" /></br>
</form>
<p style="text-align:center;font-size:14px;color:#888">
<a style="color:blue;" href="userinfo.php">Go back</a></p>
</div>
</body>
</html> 
