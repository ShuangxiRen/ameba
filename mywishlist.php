<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae wish list</title>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family:Arial, Sans-serif;}
a {
  text-decoration:none;
  color:blue;
}
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
  width:80%;
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
</style>
</head>

<body>
<p style="text-align:center">
<a style="color:blue;" class="pagename" href="index.php">amabae</a><br>
<span style="font-size:28px;">My Wishlist</span>
</p>  
<?php
session_start();
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
include "dbconnect2.php";
$sql = "select W.wishtime, I.ItemID, I.item_name, S.price from Wishlist W, Items I, Sale_items S where W.UserID = '$userid' and  W.ItemID = I.ItemID and I.ItemID = S.ItemID order by W.wishtime DESC";
$query = mysqli_query($conn, $sql);
echo "<table>
<tr style = 'font-size:10pt'>
<th style='width:200px'>Add_Date</th>
<th style='width:500px'>Product</th>
<th style='width:180px'>Unitprice</th>
<th style='width:200px'>Operation</th>
</tr>";
while($row = mysqli_fetch_array($query))
{
/*$date = substr($row['order_time'], 0, 10);
echo $date.",";
echo $row['bidornot'].",";
echo $row['seller'].",";
echo $row['supplier'].",";
echo $row['item_name'].",";
echo $row['price'].",";
echo $row['amount'].",";
echo $row['shippingfee'].",";
echo $row['status'].",";
echo'<br/>';*/
	
	$itemid = $row['ItemID'];
	$itemname = $row['item_name'];
   	echo "<tr>"; 
   	echo "<td style='height:30px'>".$row['wishtime']."</td>";
	echo "<td><a href='singlesaleitem.php?itemid=".$itemid."' style='text-decoration:none;'>".$itemname."</a></td>";
   	/*echo "<td>".$row['item_name']."</td>";*/
   	echo "<td>$".$row['price']."</td>";
	echo "<td>&nbsp&nbsp&nbsp<a href='deletewishlist.php?wishitemid=".$itemid."' style='text-decoration:none;'>
	delete
	</a></td>";
  echo "</tr>";
}
echo "</table><br/>";
mysqli_close($conn);
?>
</body>
</html> 
