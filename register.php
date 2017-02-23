<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae registration</title>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-acale=1">
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
<p>
<div>
<p style="font-size:28px;">Register</p>

<?php
$vusername = $vemail = $vgender = $vpassword1 = $vpassword2 = "";
$fusernameErr = $femailErr = $fgenderErr = $fpasswordErr1 = $fpasswordErr2 = "";
$inputok = true;
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(empty($_POST['fusername'])){
    $fusernameErr = "User name is required";
	$inputok = false;
  }else{
    $vusername = clean_input($_POST['fusername']);
	if(!preg_match("/^[A-Za-z0-9]+$/", $vusername)){
	  $fusernameErr = "Only letters and numbers allowed";
	  $inputok = false;
	}
  }
  if(empty($_POST['femail'])){
    $femailErr = "Email is required";
	$inputok = false;
  }else{
    $vemail = clean_input($_POST['femail']);
	if(!filter_var($vemail, FILTER_VALIDATE_EMAIL)){
	  $femailErr = "Email address is invalid";
	  $inputok = false;
	}
  }
  if(empty($_POST['fpassword1'])){
    $fpasswordErr1 = "Password is required";
	$inputok = false;
  }else{
    $vpassword1 = clean_input($_POST['fpassword1']);
  }
  if(empty($_POST['fpassword2'])){
    $fpasswordErr2 = "Password is required";
	$inputok = false;
  }else{
    $vpassword2 = clean_input($_POST['fpassword2']);
  }
  if(!empty($_POST['fpassword1']) && !empty($_POST['fpassword2'])){
    $vpassword1 = clean_input($_POST['fpassword1']);
    $vpassword2 = clean_input($_POST['fpassword2']);
    if($vpassword1 != $vpassword2){
	  $fpasswordErr1 = "The passwords you input not match";
	  $inputok = false;
	}
  }
  if(empty($_POST['fgender'])){
    $fgenderErr = "Gender required";
	$inputok = false;
  }else{
    $vgender = clean_input($_POST['fgender']);
  }
  if($inputok == true){//now begin to manipulate database
	include "dbconnect2.php";
	$prestmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($prestmt, "select count(*) from Users where username = ?")){
	  echo "SQL prepare error";
	  mysqli_close($conn);
	  exit();
	}
	mysqli_stmt_bind_param($prestmt, "s", $vusername);
	mysqli_stmt_execute($prestmt);
	mysqli_stmt_bind_result($prestmt,$userexist);
	mysqli_stmt_fetch($prestmt);
	if($userexist > 0){
	  $fusernameErr = "User name exists try another one";
	  mysqli_stmt_close($prestmt);
	  mysqli_close($conn);
	}else{//insert new user into database
	  if(!mysqli_stmt_prepare($prestmt, "insert into Users(username, password, email, gender) values(?, ?, ?, ?)")){
	    echo "SQL prepare error";
		mysqli_stmt_close($prestmt);
	    mysqli_close($conn);
	    exit();
	  }
	  mysqli_stmt_bind_param($prestmt, "ssss", $vusername, $vpassword1, $vemail, $vgender); 
	  mysqli_stmt_execute($prestmt);
	  if(!mysqli_stmt_prepare($prestmt, "select UserID from Users where username = ?")){
	    echo "SQL prepare error";
		mysqli_stmt_close($prestmt);
	    mysqli_close($conn);
	    exit();
	  }
	  mysqli_stmt_bind_param($prestmt, "s", $vusername);
	  mysqli_stmt_execute($prestmt);
	  mysqli_stmt_bind_result($prestmt, $dbuserid);
	  mysqli_stmt_fetch($prestmt);
	  $_SESSION['uid'] = $dbuserid;
	  $_SESSION['uname'] = $vusername;
	  mysqli_stmt_close($prestmt);
          /***************************message***********************/
          $medate = date('Y-m-d H:i:s');
	  $messagesql = "insert into Message(sendtime, type, fromname, toname, message, title, status) 
	  values('$medate','1','Amabae', '$vusername','Welcome to Amabae!','System notice', '1')";
	  mysqli_query($conn, $messagesql);
	  mysqli_close($conn);
	  header("Location:index.php");
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
<input type="text" name="fusername" placeholder="Only letters and numbers allowed" value="<?php echo $vusername; ?>">
<br/>
<br/>
<span class="label">Email:&nbsp&nbsp</span><span class="error"><?php echo $femailErr; ?></span><br>
<input type="text" name="femail" value="<?php echo $vemail; ?>">
<br/>
<br/>
<span class="label">Password:&nbsp&nbsp</span><span class="error"><?php echo $fpasswordErr1; ?></span><br>
<input type="password" name="fpassword1">
</br>
</br>
<span class="label">Password again:&nbsp&nbsp</span><span class="error"><?php echo $fpasswordErr2; ?></span><br>
<input type="password" name="fpassword2">
</br>
</br>
<span class="label">Gender:&nbsp</span>
<input type="radio" name="fgender" value="male"
<?php if(isset($vgender) && $vgender == "male"){echo "checked";} ?>>Male
<input type="radio" name="fgender" value="female"
<?php if(isset($vgender) && $vgender == "female"){echo "checked";} ?>>Female
<span class="error">&nbsp<?php echo $fgenderErr; ?></span>
</br>
</br>
<input type="submit"  value="Create my Amabae account" /></br>
</form>
<p style="text-align:center;font-size:14px;color:#888">
I already have an Amabae account&nbsp&nbsp<a style="color:blue;" href="signin.php">Sign in</a></p>
<br/>
</div>
</body>
</html> 
