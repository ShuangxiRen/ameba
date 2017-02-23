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
$orderid = $_SESSION['payid'];
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
/*echo $username;
echo '<br/>';
echo $userid;
echo '<br/>';
echo $saleitemid;
echo '<br/>';*/
include "dbconnect2.php";
$ordersql="select OrderID, ItemID, buyer, seller, amount, status from Orders where OrderID = '$orderid'";
$orderquery = mysqli_query($conn, $ordersql);
$bidorder = mysqli_fetch_array($orderquery);
$itemid = $bidorder['ItemID'];
$theseller = $bidorder['seller'];
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
$sql2="update Orders set cardtype = '$cardtype', creditcard = '$cardnumber',status = 1 where OrderID = '$orderid'";
if(!mysqli_query($conn, $sql2))
{
	echo '<center>';
    echo'<br/><br/><br/><br/><br/><br/>';
    echo'<span style="font-size:20pt;color:red">Pay failed!</span><br/><br/>';
	echo '</center>';
	mysqli_close($conn);
    exit;   
}
$sql4 = "select item_name from Items where ItemID = '$itemid'";
$query4 = mysqli_query($conn, $sql4);
$query4row = mysqli_fetch_array($query4);
$itemname1 = $query4row[0];
$itemname = addslashes($itemname1);
$buyeraddr = "<br/>&nbsp&nbsp&nbsp&nbsp".$street."<br/>&nbsp&nbsp&nbsp&nbsp".$city.",&nbsp&nbsp".$state."&nbsp&nbsp".$zip."<br/>";
$message = $username."&nbsp&nbsphas made payment for your product&nbsp&nbsp\"".$itemname."\"&nbsp&nbspon auction. Please delivery.<br/>Address:".$buyeraddr."Phone:&nbsp&nbsp&nbsp&nbsp".$phone."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
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
$paytime = date('Y-m-d H:i:s');
$sql4 = "insert into Message(MessageID, sendtime, type, fromname, toname, message, title, status) values('$newmessageid','$paytime','1','Amabae','$sellername','$message','Paid and delivery','1')";
if(!mysqli_query($conn, $sql4))
{
	echo '<center>';
    echo'<br/><br/><br/><br/><br/><br/>';
    echo'<span style="font-size:20pt;color:red">Pay failed!</span><br/><br/>';
	echo '</center>';
	mysqli_close($conn);
    exit;   
}

echo "<br/><br/><br/>";
echo '<center>';
echo '<p style="color:red;font-family:arial,sans-serif;font-size:20pt;text-decoration:none">';
echo "Pay successful!<br/><br/>";
echo '<a href="myorder.php" style="font-size:20pt;color:blue;text-decoration:none">OK</a><br/>';
echo '</p>';
echo '</center>';
mysqli_close($conn);
/*****************************************************************************************************************/
?>