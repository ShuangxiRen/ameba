<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae rate</title>
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
<p style="text-align:center">
<a style="color:blue;" class="pagename" href="index.php">amabae</a><br>
<span style="font-size:28px;">Rate the seller</span>
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
$orderid = $_GET['ORDERID'];
echo '<br/>';
/****************************************************************************************************************/
include "dbconnect2.php";
$selorsup = mysqli_query($conn, "select order_time, seller,supplier, source from Orders where OrderID = '$orderid'");
$row = mysqli_fetch_array($selorsup);
$seller = $row['seller'];
$supplier = $row['supplier'];
$source = $row['source'];
$date = $row['order_time'];
echo '<div style="font-family:arial,sans-serif;font-size:12pt;text-align:left;padding-left:200px">';
if($seller == 0){
    $sql1 = "select O.ItemID, S.compname, I.item_name from Orders O, Items I, Suppliers S where O.OrderID='$orderid' and O.supplier = S.SupplierID and O.ItemID = I.ItemID";
    $query1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_array($query1);
	$supname = $row1['compname'];
	$itemname = $row1['item_name'];
    echo '<font size=4pt><b>Order time</b>:</font>&nbsp&nbsp'.$date.'<br/><br/>';
    echo '<font size=4pt><b>Supplier</b>:</font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$supname.'<br/><br/>';
    echo '<font size=4pt><b>Product</b>:</font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$itemname.'<br/><br/>';
}
else{
    $sql2 = "select O.ItemID, U.username, I.item_name from Orders O, Items I, Users U where O.OrderID = '$orderid' and O.seller = U.UserID and O.ItemID = I.ItemID";
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($query2);
	$sellername = $row2['username'];
	$itemname = $row2['item_name'];
    echo '<font size=4pt><b>Order time</b>:</font>&nbsp&nbsp'.$date.'<br/><br/>';
    echo '<font size=4pt><b>Seller</b>:</font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$sellername.'<br/><br/>';
    echo '<font size=4pt><b>Product</b>:</font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$itemname.'<br/><br/>';
}
echo '<form action="writerating.php" method="post">';
echo '<input type="Hidden" name="orderid" value="'.$orderid.'">';
echo '<input type="Hidden" name="source" value="'.$source.'">';
echo '<input type="Hidden" name="seller" value="'.$seller.'">';
echo '<font size=4pt><b>Rating</b>:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</font>';
echo '<input type="radio" name="score" value="1" />1
&nbsp&nbsp
<input type="radio" name="score" value="2" />2
&nbsp&nbsp
<input type="radio" name="score" value="3" />3
&nbsp&nbsp
<input type="radio" name="score" value="4" />4
&nbsp&nbsp
<input type="radio" name="score" value="5" />5
&nbsp&nbsp
<input type="radio" name="score" value="6" />6
&nbsp&nbsp
<input type="radio" name="score" value="7" />7
&nbsp&nbsp
<input type="radio" name="score" value="8" />8
&nbsp&nbsp
<input type="radio" name="score" value="9" />9
&nbsp&nbsp
<input type="radio" name="score" value="10" />10<br/><br/>';
/*echo '<input type = "text" style="width:100px;height:23px" name="score" /><i>(0~10)</i><br/><br/>';*/
echo '<font size=4pt><b>Comment</b>:</font><br/><br/>';
echo '<textarea name="comment" cols ="83" rows = "10"></textarea><br/><br/><br/>';
echo '<input type="submit" style="margin-left:10%;width:200px" value="Submit Review" />';
echo '</form>';
echo "</div>";
mysqli_close($conn);
?>
</body>
</html> 
