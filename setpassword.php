<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae set password</title>
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
<p style="text-align:center; font-size:28px;">change password</p>

<?php
$vnewp = $voldp = $vnewp1 = $vnewp2 = "";
$foldpErr = $fnewpErr1 = $fnewpErr2 = "";
$inputok = true;
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(empty($_POST['foldp'])){
    $foldpErr = "Old password is required";
	$inputok = false;
  }else{
    $voldp = clean_input($_POST['foldp']);
	$query = mysqli_query($conn, "select password from Users where username = '$vusername'");
	$row = mysqli_fetch_array($query);
	$dboldp = $row['password'];
	if($voldp != $dboldp){
	  $foldpErr = "The old password is not correct";
	  $inputok = false;
    }
  }
  if(empty($_POST['fnewp1'])){
    $fnewpErr1 = "New password is required";
	$inputok = false;
  }else{
    $vnewp1 = clean_input($_POST['fnewp1']);
  }
  if(empty($_POST['fnewp2'])){
    $fnewpErr2 = "New password again";
	$inputok = false;
  }else{
    $vnewp2 = clean_input($_POST['fnewp2']);
  }
  if(!empty($_POST['fnewp1']) && !empty($_POST['fnewp2'])){
    $vnewp1 = clean_input($_POST['fnewp1']);
	$vnewp2 = clean_input($_POST['fnewp2']);
	if($vnewp1 != $vnewp2){
	  $fnewpErr1 = "The new passwords you input not match";
	  $inputok = false;
	}
  }
  if($inputok == true){//now begin to verify if the $vusername and $vpassword is in database
	$prestmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($prestmt, "update Users set password = ? where username = '$vusername'")){
	  echo "SQL prepare error";
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	  exit();
	}
	mysqli_stmt_bind_param($prestmt, "s", $vnewp1);
	mysqli_stmt_execute($prestmt);
	mysqli_stmt_close($prestmt);
	mysqli_close($conn);
	echo '<script>
	alert("update password successfully!");
	window.location.href = "userinfo.php";
	</script>';
	//header("Location:userinfo.php");
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
<span class="label">Old password:&nbsp&nbsp</span><span class="error"><?php echo $foldpErr; ?></span><br>
<input type="password" name="foldp">
<br/>
<br/>
<span class="label">New password:&nbsp&nbsp</span><span class="error"><?php echo $fnewpErr1; ?></span><br>
<input type="password" name="fnewp1">
</br>
</br>
<span class="label">New password again:&nbsp&nbsp</span><span class="error"><?php echo $fnewpErr2; ?></span><br>
<input type="password" name="fnewp2">
</br>
</br>
<input type="submit"  value="Change password" /></br>
</form>
<p style="text-align:center;font-size:14px;color:#888">
<a style="color:blue;" href="userinfo.php">Go back</a></p>
<br>
</div>
</body>
</html> 
