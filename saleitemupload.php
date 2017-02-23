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
$_SESSION['uname'] = $username;
$_SESSION['uid'] = $userid;
$sellerid = $userid;
$itemnametmp = $_POST['itname'];
$itemname = addslashes($itemnametmp);
$category = $_POST['category'];
$description1 = $_POST['description'];
$description = addslashes($description1);
$quantity = $_POST['quantity'];
$locationtmp = $_POST['location'];
$location = addslashes($locationtmp);
$price = $_POST['price'];
$shippinginfotmp = $_POST['shippinginfo'];
$shippinginfo = addslashes($shippinginfotmp);
$shippingprice = $_POST['shippingprice'];
if(!$quantity || !$itemname || !$description || !$location || !$shippinginfo){
        echo'<br/><br/><br/><br/><br/><br/>';
		echo '<center>';
        echo'<span style="font-size:20pt;color:red">Please fill up every blank!</span><br/><br/>';
        echo'<a href="saleitem.php" style="font-size:25pt;color:blue;text-decoration:none">Go back</a><br/>';
		echo '</center>';
        exit;   
}
/*echo $sellerid;
echo "<br/>";
echo $category;
echo "<br/>";
echo $itemname;
echo "<br/>";
echo $description;
echo "<br/>";
echo $quantity;
echo "<br/>";
echo $location;
echo "<br/>";
echo $price;
echo "<br/>";
echo $shippinginfo;
echo "<br/>";
echo $shippingprice;*/
include "dbconnect2.php";
$query = mysqli_query($conn, "select MAX(ItemID) from Items");
$queryrow = mysqli_fetch_array($query);
$result = $queryrow[0];
$itemid = $result + 1;
$saleitemid = $itemid;
$uptime = date('Y-m-d H:i:s');
$sql = "insert into Items(ItemID,category,item_name,description,shippinginfo,shippingprice,location,uploadtime,quantity,source) value('$itemid','$category','$itemname','$description','$shippinginfo','$shippingprice','$location','$uptime','$quantity',1)";
$sql2 = "insert into Sale_items(ItemID,saleitemsource,price,sellerid,soldquantity) value('$saleitemid',1,'$price','$sellerid',0)";
$delete = "delete from Items where ItemID = '$itemid'";
$delete2 = "delete from Sale_items where ItemID = '$saleitemid'";
/*echo $saleitemid;
echo "<br/>";
echo $price;
echo "<br/>";
echo $sellerid;
echo "<br/>";*/

if(!mysqli_query($conn, $sql) || !mysqli_query($conn, $sql2)){
		mysqli_query($conn, $delete);
		mysqli_query($conn, $delete2);
        mysqli_close($conn);
        echo'<br/><br/><br/><br/><br/><br/>';
		echo '<center>';
        echo'<span style="font-size:20pt;color:red">There is something wrong of your input!</span><br/><br/>';
        echo'<a href="saleitem.php" style="font-size:25pt;color:blue;text-decoration:none">Go back</a><br/>';
		echo '</center>';
        exit;
}
else{	
		mysqli_close($conn);
		header('Location: salepictureupload.php?itemid='.$itemid);
}
?>

