<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae pay</title>
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
input[type=text], input[type=date], input[type=time] {
  display:inline-block;
  padding:3px 0;
  border:1px solid #aaa;
  border-radius:3px;
  border-sizing:border-box;
}
input[type=submit] {
  display:inline-block;
  padding:8px 15px;
  border:none;
  border-radius:3px;
  background-color:#4CAF50;
  color:white;
  cursor:pointer;
}
input[type=submit]:hover {
  background-color:#45A049;
}
</style>
</head>
<body>
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
$saleitemid=$_SESSION['saleitemid'];
$quantity = $_POST['buynum'];
$_SESSION['saleitemid'] = $saleitemid;
$_SESSION['buynum'] = $quantity;
/*echo $username;
echo '<br/>';
echo $userid;
echo '<br/>';
echo $saleitemid;
echo '<br/>';*/
include "dbconnect2.php";
$sql1 = "select cardtype,card_number,expire from Creditcard where UserID = '$userid'"; 
$query1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($query1);
$sql2 = "select I.shippingprice,S.price from Items I, Sale_items S where I.ItemID = '$saleitemid' and I.ItemID = S.ItemID"; 
$query2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($query2);
$sql3 = "select state,city,street,zip from Address where UserID = '$userid'"; 
$query3 = mysqli_query($conn, $sql3);
$row3 = mysqli_fetch_array($query3);
$sql4 = "select phonenumber from Phone where UserID = '$userid'"; 
$query4 = mysqli_query($conn, $sql4);
$row4 = mysqli_fetch_array($query4);
/******************************************************************************************************************************/
$amount = $row2['price']*$quantity + $row2['shippingprice'];
echo "<br/><br/>";
echo '<div style="margin:auto;width:600px;overflow:auto;">';
echo '<span style="font-weight:bold;font-size:25px;color:red">Amount:&nbsp&nbsp$'.$amount.'</span><br/><br/>';
echo '<hr style="border-bottom:1px solid #D3D3D3;border-top:none">';
echo '<br/>';
echo '<b>Credit Card:</b><br/><br/>';
echo '<div style="margin-left:5%;">';
echo '<form action="saleitempayresult.php" method="post">';
echo '&nbsp&nbsp&nbsp&nbsp&nbspCard type:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	  <input type="text" style="width:94px" name="cardtype" value ='.$row1['cardtype'].'>
								&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
echo 'Expire date:&nbsp&nbsp&nbsp<input type="text" style="width:94px" name="expire" value ='.$row1['expire'].'><br/><br/><br/>';
echo '&nbsp&nbsp&nbsp&nbsp&nbspCard number:&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" style="width:200px" name="cardnumber" value ='.$row1['card_number'].'><br/><br/>';
echo '</div>';
echo '<hr style="border-bottom:1px solid #D3D3D3;border-top:none">';
echo '<br/>';
echo "<b>Address:</b><br/><br/>";
echo '<div style="margin-left:5%;">';
echo '&nbsp&nbsp&nbsp&nbsp&nbspState:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" style="width:150px" name="state" value ="'.$row3['state'].'">&nbsp&nbsp&nbsp&nbsp&nbsp';
echo 'City:&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" style="width:200px" name="city" value ="'.$row3['city'].'"><br/><br/>';
echo '&nbsp&nbsp&nbsp&nbsp&nbspStreet:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" style="width:430px" name="street" value ="'.$row3['street'].'">';
echo '<br/><br/>';
echo '&nbsp&nbsp&nbsp&nbsp&nbspZip code:&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" style="width:100px" name="zip" value ="'.$row3['zip'].'"><br/><br/>';
echo '</div>';
echo '<hr style="border-bottom:1px solid #D3D3D3;border-top:none">';
echo '<br/>';
echo '<b>Phone:</b>&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" style="width:200px" name="phone" value ="'.$row4['phonenumber'].'"><br/><br/>';
echo '<input type="submit" style="margin-left:20%;width:200px;" value="Confirm" />';
echo '&nbsp&nbsp&nbsp&nbsp<a style="color:blue" href="singlesaleitem.php?itemid='.$saleitemid.'">Go back</a>';
echo '</form>';
echo '</div>';
echo '</p>';
mysqli_close($conn);
/*****************************************************************************************************************/
?>
</body>
</html> 
