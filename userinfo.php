<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Amabae user information</title>
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
  font-size:45px;
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
input[type=submit], button{
  display:inline-block;
  padding:5px;
  border:none;
  border-radius:8px;
  background-color:#4CAF50;
  color:white;
  cursor:pointer;
}
input[type=submit]:hover,button:hover {
  background-color:#45A049;
}
div.main {
  width:700px;
  margin:auto;/*keep it center of the page*/
}
div.info {
  display:inline-block;
  width:70%;
}
div.change {
  display:inline-block;
  margin-right:20px;
}
span.info{
  font-family:Serif;
  font-size:16px;
}
span.label {
  display:inline-block;
  width:120px;
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
<a style="color:blue;" class="pagename" href="index.php">amabae</a><br>
<span style="font-size:28px;">Persional Information Update</span>
</p>
<br>
<div class="main">
<hr>
<b>Profile:</b><br><br>
<div style="padding: 0 10px">
<?php
$query = mysqli_query($conn, "select username, email, gender, rating, status from Users where userid = $vuserid");
$row = mysqli_fetch_array($query);
echo "<div class='info'><span class='label'>User name:</span>"."<span class='info'>".$row['username']."</span>";
echo "<br><span class='label'>Email:</span>"."<span class='info'>".$row['email']."</span>";
echo "<br><span class='label'>Gender:</span>"."<span class='info'>".$row['gender']."</span>";
echo "<br><span class='label'>Rating score:</span>"."<span class='info'>".$row['rating']."</span>";
$status = "active";
if($row['status'] == 1){$status = "limited";}
echo "<br><span class='label'>Status:</span>"."<span class='info'>".$status."</span>";
?>
</div>
<div class="change">
<button style="width:130px;" onclick="window.location.href='setpassword.php'">Change password</button>
<!--
<form action="setpassword.php">
<input style="width:130px;" type="submit" name="changepassword" value="Change password">
</form>
-->
</div>
</div>
<hr>
</div>
<div class="main">
<b>Address</b><br><br>
<div style="padding: 0 10px">
<?php
$query = mysqli_query($conn, "select state, city, street, zip from Address where UserID = '$vuserid'");
if(mysqli_num_rows($query) == 0){
  echo '<div class="info"></div>';
  echo '<div class="change">
  <button style="width:130px;" onclick="window.location.href=\'setaddress.php\'">Add address</button>
  </div>';
}else{
  $row = mysqli_fetch_array($query);
  echo "<div class='info'>".$row['street']."<br>";
  echo $row['city'].", ".$row['state']."<br>";
  echo $row['zip']."</div>";
  echo '<div class="change">
  <button style="width:130px;" onclick="window.location.href=\'setaddress.php\'">Change address</button>
  </div>';
}
?>
</div>
<hr>
</div>
<div class="main">
<b>Phone</b><br><br>
<div style="padding: 0 10px">
<?php
$query = mysqli_query($conn, "select phonenumber from Phone where UserID = '$vuserid'");
if(mysqli_num_rows($query) == 0){
  echo '<div class="info"></div>';
  echo '<div class="change">
  <button style="width:130px;" onclick="window.location.href=\'setphone.php\'">Add phone</button>
  </div>';
}else{
  $row = mysqli_fetch_array($query);
  echo "<div class='info'>".$row['phonenumber']."</div>";
  echo '<div class="change">
  <button style="width:130px;" onclick="window.location.href=\'setphone.php\'">Change phone</button>
  </div>';
}
?>
</div>
<hr>
</div>
<div class="main">
<b>Credit card</b><br><br>
<div style="padding: 0 10px">
<?php
$query = mysqli_query($conn, "select cardtype, card_number, expire from Creditcard where UserID = '$vuserid'");
if(mysqli_num_rows($query) == 0){
  echo '<div class="info"></div>';
  echo '<div class="change">
  <button style="width:130px;" onclick="window.location.href=\'setcard.php\'">Add card</button>
  </div>';
}else{
  $row = mysqli_fetch_array($query);
  echo "<div class='info'><span class='label'>Card type:</span>".$row['cardtype']."<br>";
  echo "<span class='label'>Card number:</span>".$row['card_number']."<br>";
  echo "<span class='label'>Expire date:</span>".$row['expire']."</div>";
  echo '<div class="change">
  <button style="width:130px;" onclick="window.location.href=\'setcard.php\'">Change card</button>
  </div>';
}
mysqli_close($conn);
?>
</div>
</div>
<br><br>
</body>
</html> 
