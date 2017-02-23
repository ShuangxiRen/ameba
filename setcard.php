<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae set creditcard</title>
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
<p style="text-align:center; font-size:28px;">Set creditcard</p>

<?php
$vcardtype = $vcardnum= $vexpire = "";
$fcardtypeErr = $fcardnumErr = $fexpireErr = "";
$inputok = true;
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(empty($_POST['fcardtype'])){
    $fcardtypeErr = "Card type is required";
	$inputok = false;
  }else{
    $vcardtype = clean_input($_POST['fcardtype']);
  }
  if(empty($_POST['fcardnum'])){
    $fcardnumErr = "Card number is required";
	$inputok = false;
  }else{
    $vcardnum = clean_input($_POST['fcardnum']);
	if(!preg_match("/^[0-9]+$/", $vcardnum)){
	  $fcardnumErr = "Credit card number is invalid";
	  $inputok = false;
	}
  }
  if(empty($_POST['fexpire'])){
    $fexpireErr = "Expire date is required";
	$inputok = false;
  }else{
    $vexpire = clean_input($_POST['fexpire']);
  }
  if($inputok == true){//now begin to delete old and insert new card in database
    if(!$query = mysqli_query($conn, "delete from Creditcard where UserID = '$vuserid'")){
	  echo "delete old creditcard failed";
	  mysqli_close($conn);
	  exit();
	}
	$prestmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($prestmt, "insert into Creditcard(UserID, cardtype, card_number, expire) values(?, ?, ?, ?)")){
	  echo "SQL prepare error";
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	  exit();
	}
	mysqli_stmt_bind_param($prestmt, "ssss", $vuserid, $vcardtype, $vcardnum, $vexpire);
	if(!mysqli_stmt_execute($prestmt)){
	  echo "insert new creditcard failed";
	  mysqli_close($conn);
	  exit();
	}else{
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	  echo '<script>
	  alert("Set creditcard successfully!");
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
<span class="label">Card type:&nbsp&nbsp</span><span class="error"><?php echo $fcardtypeErr; ?></span><br>
<input type="text" name="fcardtype" value="<?php echo $vcardtype; ?>">
<br/>
<br/>
<span class="label">Card number:&nbsp&nbsp</span><span class="error"><?php echo $fcardnumErr; ?></span><br>
<input type="text" name="fcardnum" value="<?php echo $vcardnum; ?>">
<br/>
<br/>
<span class="label">Expire date:&nbsp&nbsp</span><span class="error"><?php echo $fexpireErr; ?></span><br>
<input type="date" name="fexpire" placeholder="yyyy/mm/dd" value="<?php echo $vexpire; ?>">
<br/>
<br/>
<input type="submit"  value="Set creditcard" /></br>
</form>
<p style="text-align:center;font-size:14px;color:#888">
<a style="color:blue;" href="userinfo.php">Go back</a></p>
</div>
</body>
</html> 
