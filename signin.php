<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae sign in</title>
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
<p style="text-align:center">
<a class="pagename" href="index.php">amabae</a>
</p>
<div>
<p style="font-size:28px;">Sign in</p>

<?php
$vusername = $vpassword = $fusernameErr = $fpasswordErr = "";
$inputok = true;
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(empty($_POST['fusername'])){
    $fusernameErr = "User name is required";
	$inputok = false;
  }else{
    $vusername = clean_input($_POST['fusername']);
  }
  if(empty($_POST['fpassword'])){
    $fpasswordErr = "Password is required";
	$inputok = false;
  }else{
    $vpassword = clean_input($_POST['fpassword']);
  }
  if($inputok == true){//now begin to verify if the $vusername and $vpassword is in database
	include "dbconnect2.php";
	$prestmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($prestmt, "select UserID from Users where username = ? and password = ?")){
	  echo "SQL prepare error";
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	  exit();
	}
	mysqli_stmt_bind_param($prestmt, "ss", $vusername, $vpassword);
	mysqli_stmt_execute($prestmt);
	mysqli_stmt_store_result($prestmt);
	if(mysqli_stmt_num_rows($prestmt) == 0){
	  $fpasswordErr = "Password is NOT correct";
	  mysqli_stmt_free_result($prestmt);
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	}else{//match successfully
	  mysqli_stmt_bind_result($prestmt,$vuserid);
	  mysqli_stmt_fetch($prestmt);
	  $_SESSION['uid'] = $vuserid;
	  $_SESSION['uname'] = $vusername;
	  mysqli_stmt_free_result($prestmt);
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
          echo '<script>
          window.location.href = "index.php";
          </script>';
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
<span class="label">User name:&nbsp&nbsp</span><span class="error"><?php echo $fusernameErr; ?></span><br>
<input type="text" name="fusername" value="<?php echo $vusername; ?>">
<br/>
<br/>
<span class="label">Password:&nbsp&nbsp</span><span class="error"><?php echo $fpasswordErr; ?></span><br>
<input type="password" name="fpassword">
</br>
</br>
<input type="submit"  value="Sign in" /></br>
</form>
<p style="text-align:center;font-size:14px;color:#888">
I am new to Amabae&nbsp&nbsp<a style="color:blue;" href="register.php">Register</a></p>
<br/>
</div>
</body>
</html> 
