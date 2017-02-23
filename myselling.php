<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae sell list</title>
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
<span style="font-size:28px;">Selling Information</span>
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
$sql = "select O.OrderID,O.order_time,O.bidornot,U.username,O.supplier,I.item_name,O.price,O.quantity,O.amount,O.shippingfee,O.status from Orders O, Items I,Users U where O.seller = '$userid' and O.ItemID = I.ItemID and O.buyer = U.UserID order by O.order_time DESC";
$query = mysqli_query($conn, $sql);
echo "<table>
<tr style = 'font-size:10pt'>
<th style='width:130px'>Date</th>
<th style='width:80px'>Type</th>
<th style='width:180px'>Buyer</th>
<th style='width:500px'>Item Name</th>
<th style='width:130px'>Unitprice</th>
<th style='width:110px'>Quantity</th>
<th style='width:130px'>Subtotal</th>
<th style='width:150px'>Shippingfee</th>
<th style='width:150px'>Amount</th>
<th style='width:590px'>Status</th>
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
   	echo "<td style='height:30px'>".$date."</td>";
   	echo "<td>".$type."</td>";
   	echo "<td>".$row['username']."</td>";
   	echo "<td>".$row['item_name']."</td>";
   	echo "<td>$".$unitprice."</td>";
   	echo "<td>".$row['quantity']."</td>";
   	echo "<td>$".$subtotal."</td>";
   	echo "<td>$".$row['shippingfee']."</td>";
   	echo "<td>$".$theamount."</td>";
	switch($row['status']){
		case 0:
   			echo "<td>Waiting for payment.</td>";
			break;
		case 1:
   			echo "<td>
			<form action='sent.php' method='get'>Paid and waiting for delivery.
								 &nbsp&nbsp&nbsp&nbsp&nbsp
			<input type='Hidden' name='ORDERID' value='".$orderid."'>
			<input type='submit' style='width:160px' value='The product has shipped'/>
			</form>
			</td>";
			break;
		case 2:
   			echo "<td>On delivery.</td>";
			break;
		case 3:
   			echo "<td>Delivered and waiting for reviewing.</td>";
			break;
		case 4:
			echo "<td>Complete.&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                <a href='checkreview.php'>Check review</td>";
			break;
	}
   	echo "</tr>";
}
echo "</table><br/>";
mysqli_close($conn);
?>
</body>
</html> 
