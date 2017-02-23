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
$saleitemid=$_SESSION['saleitemid'];
$buynum=$_SESSION['buynum'];
$cardtype = $_POST['cardtype'];
$cardnumber = $_POST['cardnumber'];
$state = $_POST['state'];
$city = $_POST['city'];
$streettmp = $_POST['street'];
$street = addslashes($streettmp);
$zip = $_POST['zip'];
$phone = $_POST['phone'];
$_SESSION['uname'] = $username;
$_SESSION['uid'] = $userid;
$_SESSION['saleitemid'] = $itemid;
/*echo $username;
echo '<br/>';
echo $userid;
echo '<br/>';
echo $saleitemid;
echo '<br/>';*/
include "dbconnect2.php";
$sql = "select MAX(OrderID) from Orders"; 
$query = mysqli_query($conn, $sql);
$queryrow = mysqli_fetch_array($query);
$result = $queryrow[0];
$orderid = $result + 1;
$sql = "select I.source,I.category,I.shippingprice,I.quantity,S.sellerid,S.supplierid,S.price from Items I, Sale_items S where I.ItemID = '$saleitemid' and I.ItemID = S.ItemID"; 
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
/******************************************************************************************************************************/
if($row['quantity'] < $buynum)
{
        mysqli_close($conn);
        echo '<center>';
        echo'<br/><br/><br/><br/><br/><br/>';
        echo'<span style="font-size:20pt;color:red">Product left is not enough!</span><br/><br/>';
        echo'<a href="singlesaleitem.php?itemid='.$saleitemid.'" style="font-size:25pt;color:blue;text-decoration:none">Go back</a><br/>';
        echo '</center>';
        exit;
}
$ordertime = date('Y-m-d H:i:s');
$thesource = $row['source'];
$thecategory = $row['category'];
$theseller = $row['sellerid'];
$thesup = $row['supplierid'];
$theprice = $row['price'];
$theshfee = $row['shippingprice'];
$money = $theprice*$buynum;
/*echo '<br/>';
echo $orderid;
echo '<br/>';
echo $saleitemid;
echo '<br/>';
echo $thesource;
echo '<br/>';
echo $thecategory;
echo '<br/>';
echo $buynum;
echo '<br/>';
echo $userid;
echo '<br/>';
echo $theseller;
echo '<br/>';
echo $thesup;
echo '<br/>';
echo $ordertime;
echo '<br/>';
echo $cardtype;
echo '<br/>';
echo $cardnumber;
echo '<br/>';
echo $theprice;
echo '<br/>';
echo $theshfee;
echo '<br/>';*/
/*$sql2="insert into Orders(OrderID,ItemID,source,category,quantity,buyer,seller,supplier,order_time,cardtype,creditcard,bidornot,price,shippingfee,status) values('$orderid','$saleitemid','$row['source']','$row['category']','$buynum','$userid','$row['sellerid']','$row['supplierid']','$ordertime','$cardtype','$cardnumber',0,'$row['price']','$row['shippingprice']',1)";*/
$sql2="insert into Orders(OrderID,ItemID,source,category,quantity,buyer,seller,supplier,order_time,cardtype,creditcard,bidornot,price,amount,shippingfee,status) values('$orderid','$saleitemid','$thesource','$thecategory','$buynum','$userid','$theseller','$thesup','$ordertime','$cardtype','$cardnumber',0,'$theprice','$money','$theshfee',1)";
if(!mysqli_query($conn, $sql2))
{
	echo '<center>';
    echo'<br/><br/><br/><br/><br/><br/>';
    echo'<span style="font-size:20pt;color:red">Pay failed!</span><br/><br/>';
	echo '</center>';
	mysqli_close($conn);
    exit;   
}
$sql3 = "update Sale_items set soldquantity = soldquantity+'$buynum' where ItemID = '$saleitemid'";
if(!mysqli_query($conn, $sql3))
{
	echo '<center>';
    echo'<br/><br/><br/><br/><br/><br/>';
    echo'<span style="font-size:20pt;color:red">Pay failed!</span><br/><br/>';
	echo '</center>';
	mysqli_close($conn);
    exit;   
}
$sql5 = "update Items set quantity = quantity-'$buynum' where ItemID = '$saleitemid'";
if(!mysqli_query($conn, $sql5))
{
	echo '<center>';
    echo'<br/><br/><br/><br/><br/><br/>';
    echo'<span style="font-size:20pt;color:red">Pay failed!</span><br/><br/>';
	echo '</center>';
	mysqli_close($conn);
    exit;   
}
$sql4 = "select item_name from Items where ItemID = '$saleitemid'";
$query4 = mysqli_query($conn, $sql4);
$query4row = mysqli_fetch_array($query4);
$saleitemname1 = $query4row[0];
$saleitemname = addslashes($saleitemname1);
$buyeraddr = "<br/>&nbsp&nbsp&nbsp&nbsp".$street."<br/>&nbsp&nbsp&nbsp&nbsp".$city.",&nbsp&nbsp".$state."&nbsp&nbsp".$zip."<br/>";
$message = $username."&nbsp&nbspbought&nbsp&nbsp".$buynum."&nbsp&nbspof your product&nbsp&nbsp\"".$saleitemname."\"&nbsp&nbspand have paid.<br/>Please delivery.<br/>Address:".$buyeraddr."Phone:&nbsp&nbsp&nbsp&nbsp".$phone."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
																		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
																		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
																		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
																		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
																		  <a href=\"myselling.php\" style=\"text-decoration:none\">Go to my selling</a>";
$mequery = mysqli_query($conn, "select MAX(MessageID) from Message");
$mequeryrow = mysqli_fetch_array($mequery);
$meresult = $mequeryrow[0];
$newmessageid = $meresult + 1;
$sellersql = "select username from Users where UserID = '$theseller'";
$sellerquery = mysqli_query($conn, $sellersql);
$sellerqueryrow = mysqli_fetch_array($sellerquery);
$sellername = $sellerqueryrow[0];
$sql4 = "insert into Message(MessageID, sendtime, type, fromname, toname, message, title, status) values('$newmessageid','$ordertime','1','Amabae','$sellername','$message','Paid and delivery','1')";
if(!mysqli_query($conn, $sql4))
{
	echo '<center>';
    echo'<br/><br/><br/><br/><br/><br/>';
    echo'<span style="font-size:20pt;color:red">Pay failed!</span><br/><br/>';
	echo '</center>';
    exit;   
}
echo "<br/><br/><br/>";
echo '<center>';
echo '<p style="color:red;font-family:arial,sans-serif;font-size:20pt;text-decoration:none">';
echo "Pay successful!<br/><br/>";
echo '<a href="index.php" style="font-size:20pt;color:blue;text-decoration:none">OK</a><br/>';
echo '</p>';
echo '</center>';
mysqli_close($conn);
/*****************************************************************************************************************/
?>
