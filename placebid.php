<?php
session_start();
if(!$_SESSION['uname'])
{
        echo '<center>';
        echo'<br/><br/><br/>';
		echo '<a href="index.php" style="font-size:30pt;color:blue;text-decoration:none"><img src="amabae.png"></a><br/>';
        echo'<br/>';
        echo'<p style="font-family:arial,sans-serif;font-size:24pt;color:red">Please sign in!<br/><br/>';
        echo'<a href="signin.php"  style="font-size:14pt;color:blue;text-decoration:none">Sign in</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
        echo'<a href="register.php" style="font-size:14pt;color:blue;text-decoration:none">Register</a><br/>';
		echo '</p>';
        echo '</center>';
        exit;   
}
$username = $_SESSION['uname'];
$userid = $_SESSION['uid'];
$_SESSION['uname'] = $username;
$_SESSION['uid'] = $userid;
/**************************************************************************************/
$bidmoney = $_POST['bidmoney'];
$auctionitemid = $_SESSION['auctionitemid'];
$bidtime = date('Y-m-d H:i:s');
include "dbconnect2.php";
$sql = "select reserve_price, end_time from Auction_items where ItemID = '$auctionitemid'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
$reprice = $row['reserve_price'];
$result = $row['end_time'];
$sql = "select MAX(money) from Bidding where ItemID = '$auctionitemid'";
$query = mysqli_query($conn, $sql);
$queryrow = mysqli_fetch_array($query);
$maxmoney = $queryrow[0];
$tmp = $maxmoney + 2;
if($bidtime > $result){
    echo '<p style="font-family:arial,sans-serif;font-size:24pt;color:red">Sorry, this auction ended!<br/><br/>';
    echo '<a href="index.php"  style="font-size:20pt;color:blue;text-decoration:none">OK</a>';
	echo '</p>';
	exit;
}
if($bidmoney < $reprice)
{
	echo '<center>';
	echo '<br/><br/>';
    echo '<p style="font-family:arial,sans-serif;font-size:20pt;color:red">Sorry, your bid is less than seller\'s reserve price!<br/><br/>';
    echo '<a href="singleauctionitem.php?itemid='.$auctionitemid.'"  style="font-size:20pt;color:blue;text-decoration:none">Go back</a>';
	echo '</p>';
	echo '</center>';
}
else{
if($bidmoney < $tmp ){
	echo '<center>';
	echo '<br/><br/>';
    echo '<p style="font-family:arial,sans-serif;font-size:24pt;color:red">Sorry, your bid is not the highest currently!<br/><br/>';
    echo '<a href="singleauctionitem.php?itemid='.$auctionitemid.'"  style="font-size:20pt;color:blue;text-decoration:none">Go back</a>';
	echo '</p>';
	echo '</center>';
}
else{
$sql1 = "insert into Bidding(ItemID,bid_time,bidder,money) value('$auctionitemid','$bidtime','$userid','$bidmoney')";
$sql2 = "update Auction_items set numofbidder = numofbidder + 1 where ItemID = '$auctionitemid'"; 
echo'<br/><br/><br/><br/><br/><br/>';
if(mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2))
{
	echo '<center>';
	echo'<span style="font-size:20pt;color:red">Place bid successful!</span><br/><br/>';
	echo'<span style="font-size:20pt;color:red">Result will be sent to you at &nbsp&nbsp'.$result.'</span><br/><br/><br/><br/>';
	echo'<a href="index.php" style="font-size:20pt;color:blue;text-decoration:none">OK</a><br/>';
	echo '</center>';
}
}
mysqli_close($conn);
}
?>
