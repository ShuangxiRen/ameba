<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae review center</title>
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
button {
  display:inline-block;
  padding:2px 10px;
  border:none;
  border-radius:3px;
  background-color:#4CAF50;
  color:white;
  cursor:pointer;
}
button:hover {
  background-color:#45A049;
}
table {
  margin:auto;
  border-collapse:collapse;
  width:100%;
  font-size:12px;
  
}
th {
  height:30px;
  text-align:left;
  color:white;
  background-color:#4caf50;
}
tr:nth-child(even){
  background-color:#f2f2f2;
}
tr:hover{
  background-color:#ddd;
}
tr:hover{
  background-color:#ddd;
}
</style>
</head>

<body>
<p style="text-align:center">
<a style="color:blue;" class="pagename" href="index.php">amabae</a><br>
<span style="font-size:28px;">Review Center</span>
</p>
<?php
if(!$_SESSION['uname'])
{
	echo '<center>';
	echo'<br/><br/><br/><br/><br/><br/>';
	echo'<span style="font-size:20pt;color:red">Please sign in!</span><br/><br/>';
	echo'<a href="index.php" style="font-size:25pt;color:blue;text-decoration:none">Go to homepage</a><br/>';
	echo '</center>';
	exit;
}
$username = $_SESSION['uname'];
$userid = $_SESSION['uid'];
?>
<br/>
<p>
<?php
include "dbconnect2.php";
$ratequery = mysqli_query($conn, "select R.comment_time, R.score, R.comment, O.bidornot, U.username, I.item_name from Rating R, Orders O, Users U, Items I where R.seller = '$userid' and R.OrderID = O.OrderID and R.buyer = U.UserID and O.ItemID = I.ItemID order by R.comment_time DESC");
while($row = mysqli_fetch_array($ratequery))
{
	$ratetime = $row['comment_time'];
	$reviewer = $row['username'];
	$product = $row['item_name'];
	$comment = $row['comment'];
	$myscore = $row['score'];
	if($row['bidornot'] == 0){
		$bustype = "Sale";
	}
	else{
		$bustype = "Auction";
	}
   	echo '<p style="font-family:arial,sans-serif;font-size:11pt;text-decoration:none;text-align:left;width:700px;padding-left:200px;word-wrap: break-word; word-break: break-all">';
	echo '<b>Review date:</b>&nbsp&nbsp'.$ratetime.'<br/><br/>';
	echo '<b>Reviewer:</b>&nbsp&nbsp'.$reviewer.'<br/><br/>';
	echo '<b>Business type:</b>&nbsp&nbsp'.$bustype.'<br/><br/>';
	echo '<b>Product:</b>&nbsp&nbsp'.$product.'<br/><br/>';
	echo '<b>Rating score:</b>&nbsp&nbsp'.$myscore.'<br/><br/>';
	echo '<b>Comment:</b>&nbsp&nbsp'.$comment.'<br/>';
    echo '<font color="#D3D3D3">';
    echo "_______________________________________________________________________________________</font><br/><br/><br/>";
	echo '</p>';
}
mysqli_close($conn);
?>
</p>
</body>
</html>

