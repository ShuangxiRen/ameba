<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae order list</title>
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
input[type=submit] {
  display:inline-block;
  padding:3px 5px;
  margin:5px 0 7px 0;
  border:none;
  border-radius:8px;
  background-color:#4CAF50;
  color:white;
  cursor:pointer;
}
input[type=submit]:hover {
  background-color:#45DD49;
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
<span style="font-size:28px;">Order Information</span>
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
include "dbconnect2.php";
$sql = "select O.OrderID,O.order_time,O.bidornot,O.seller,O.supplier,I.item_name,O.price,O.quantity,O.amount,O.shippingfee,O.status from Orders O, Items I where O.buyer = '$userid' and O.ItemID = I.ItemID order by O.order_time DESC";
$query = mysqli_query($conn, $sql);
echo "<table>
<tr style = 'font-size:10pt;'>
<th style='width:130px'>Order_Date</th>
<th style='width:80px'>Type</th>
<th style='width:180px'>Seller</th>
<th style='width:500px'>Item_Name</th>
<th style='width:130px'>Unitprice</th>
<th style='width:100px'>Quantity</th>
<th style='width:130px'>Subtotal</th>
<th style='width:130px'>Shippingfee</th>
<th style='width:130px'>Amount</th>
<th style='width:630px'>Status</th>
</tr>";
while($row = mysqli_fetch_array($query))
{
$date = substr($row['order_time'], 0, 10);
$orderid = $row['OrderID'];
/*echo $row['ItemID'].",";
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
   echo "<tr>"; 
   
	if($row['bidornot'] == 0){/*sale item*/	
		$type = "sale";
		$unitprice = $row['price'];
		$subtotal = $row['amount'];
	}
	else{
		$type = "bid";
		$unitprice = $row['amount'];
		$subtotal = $row['amount'];
	}
	$theamount = $subtotal + $row['shippingfee'];
	$theseller = $row['seller'];
	$thesupplier = $row['supplier'];
	if($row['supplier'] == 0){/*from individual*/
		$indquery = mysqli_query($conn, "select username from Users where UserID = '$theseller'");
		$indqueryrow = mysqli_fetch_array($indquery);
		$seller =  $indqueryrow[0];
	}
	else{/*from supplier*/
		$supquery = mysqli_query($conn, "select username from Suppliers where SupplierID = '$thesupplier'");
		$supqueryrow = mysqli_fetch_array($supquery);
		$seller =  $supqueryrow[0];
	}
   	echo "<td style='height:30px'>".$date."</td>";
   	echo "<td>".$type."</td>";
   	echo "<td>".$seller."</td>";
   	echo "<td>".$row['item_name']."</td>";
   	echo "<td>$".$unitprice."</td>";
   	echo "<td>".$row['quantity']."</td>";
   	echo "<td>$".$subtotal."</td>";
   	echo "<td>$".$row['shippingfee']."</td>";
   	echo "<td>$".$theamount."</td>";
	switch($row['status']){
		case 0:
   			echo "<td>Waiting for payment.&nbsp&nbspPay ID:&nbsp".$orderid."&nbsp&nbsp&nbsp<a href='auctionitempay.php?PAYID=".$orderid."' 
   			style='text-decoration:none;'>Click to pay</a></td>";
			break;
		case 1:
   			echo "<td>Paid and waiting for delivery.</td>";
			break;
		case 2:
   			echo "<td>
			<form action='delivered.php' method='get'>On delivery.<br>
			<input type='Hidden' name='ORDERID' value='".$orderid."'>
			<input type='submit' style='width:175px' value='I have received the product'/>
			</form>
			</td>";
			break;
		case 3:
   			echo "<td>Delivered.&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<a href='rating.php?ORDERID=".$orderid."'>Review now</td>";
			break;
		case 4:
   			echo "<td>Complete.</td>";
			break;
	}
   	echo "</tr>";
}
echo "</table><br/>";
?>
</body>
</html> 
