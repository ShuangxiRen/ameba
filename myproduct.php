<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae product list</title>
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
div {
  float:left;
}
</style>
</head>

<body>
<p style="text-align:center">
<a style="color:blue;" class="pagename" href="index.php">amabae</a><br>
<span style="font-size:28px;">Product Center</span>
</p>
<?php
if(!$_SESSION['uname'])
{
	echo '<center>';
	echo'<br><br><br><br><br><br>';
	echo'<span style="font-size:20pt;color:red">Please sign in!</span><br><br>';
	echo'<a href="index.php" style="font-size:25pt;color:blue;text-decoration:none">Go to homepage</a><br>';
	echo '</center>';
	exit;
}
$username = $_SESSION['uname'];
$userid = $_SESSION['uid'];
?>
<p>
<?php
include "dbconnect2.php";
$item = mysqli_query($conn, "select  I.ItemID,I.item_name,I.quantity,I.picture,I.description,I.shippinginfo,I.shippingprice,I.location,I.uploadtime from Items I order by I.uploadtime DESC");

echo "<br><br >"; 
while($row = mysqli_fetch_array($item))
{
    $itemname = $row['item_name'];
    $itemid = $row['ItemID'];
	$leftqty = $row['quantity'];
    $sql = "select ItemID from Sale_items where ItemID = '$itemid' and sellerid = '$userid'";
    $query = mysqli_query($conn, $sql);
	$queryrow = mysqli_fetch_array($query);
    $result = $queryrow[0];
    if($result)/*fixed price*/ 
    {
        echo '<p style="font-family:arial,sans-serif;font-size:11pt;text-decoration:none;text-align:left;padding-left:300px;">';
        /*echo '<div style="width:300px;table-layout: fixed;text-align:top;word-wrap: break-word; word-break: break-all">';*/
        echo '<img style="float:left" align = "top" src="'.$row['picture'].'"  width="100"  alt="No images available" >';
        echo '<div style="font-size:12pt;color:blue;width:400px;table-layout:fixed;text-align:top;padding-left:50px;word-wrap: break-word; word-break: break-all">';
        echo'<a href="mysaleproduct.php?itemid='.$itemid.'" style="font-size:12pt;color:blue;width:400px;text-decoration:none;table-layout: fixed;text-align:top;word-wrap: break-word; word-break: break-all">'.$itemname.'</a><br>';
        $sql = "select price,supplierid,sellerid,soldquantity from Sale_items where ItemID = '$itemid'";
        $query = mysqli_query($conn, $sql);
        $tmp = mysqli_fetch_array($query);
        if($tmp['supplierid'])/*from supplier*/
        {
            echo '<span style="color:#696969">From supplier xxx</span><br>';
        }
        else
        {
            echo '<span style="color:#696969">From individual</span><br>';
        }
        echo '<b><span style="color:black" size="5px">$'.$tmp['price'].'</span></b><br>';
        echo '<span style="color:#696969">By it now</span><br><br>';
        if($row['shippingprice'])/*not free shipping*/
        {
            echo '<span style="color:#696969">'.$row['shippinginfo'].'</span><br>';
            echo '<b><span style="color:black" size="3px">Shipping price:&nbsp$'.$row['shippingprice'].'</span></b><br>';
        }
        else{
            echo '<span style="color:#696969">'.$row['shippinginfo'].'</span><br>';
            echo '<b><span style="color:black" size="3px">Free shipping</span></b><br>';
        }
        echo '<br>';
        echo '<span style="color:#DC143C" size="3px">'.$tmp['soldquantity'].'&nbspsold</span>';
		echo '<span style="color:#DC143C" size="3px">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspStatus:&nbsp&nbsp';
		if($leftqty == 0) {echo 'Sell out</span>';}
		else {echo 'On sale</span>';}
        echo '</div>';
        echo '</div>';
        echo '</p>';
        echo '<p style="font-family:arial,sans-serif;text-decoration:none;text-align:left;padding-left:300px;">';
        echo "<br><br><br>";
        echo "<br><br><br>";
        echo "<br><br><br>";
        echo "<br><br><br>";
        echo '<span style="color:#D3D3D3">';
        echo "_________________________________________________________________________________________</span>";
    }

    else/*not fixed price, may be auction item*/
    {
    $sql = "select ItemID from Auction_items where ItemID = '$itemid' and SellerID = '$userid'";
    $query = mysqli_query($conn, $sql);
	$queryrow2 = mysqli_fetch_array($query);
    $result = $queryrow2[0];
	if($result)
	{
        $sql = "select sellerid,reserve_price,end_time,numofbidder,status from Auction_items where ItemID = '$itemid'";
        $query = mysqli_query($conn, $sql);
        $tmp = mysqli_fetch_array($query);
        $nowtime = date('Y-m-d H:i:s');
   
            echo '<p style="font-family:arial,sans-serif;font-size:11pt;text-decoration:none;text-align:left;padding-left:300px;">';
            /*echo '<div style="width:300px;table-layout: fixed;text-align:top;word-wrap: break-word; word-break: break-all">';*/
            echo '<img style="float:left" align = "top" src="'.$row['picture'].'"  width="100"  alt="No images available" >';
            echo '<div style="font-size:12pt;color:blue;width:400px;table-layout:fixed;text-align:top;padding-left:50px;word-wrap: break-word; word-break: break-all">';
            echo'<a href="myauctionproduct.php?itemid='.$itemid.'" style="font-size:12pt;color:blue;width:400px;text-decoration:none;table-layout: fixed;text-align:top;word-wrap: break-word; word-break: break-all">'.$itemname.'</a><br>';
            echo '<span style="color:#696969">Auction item</span><br><br>';
			
            if($row['shippingprice'])/*not free shipping*/
            {
                echo '<span style="color:#696969">'.$row['shippinginfo'].'</span><br>';
                echo '<b><span style="color:black" size="3px">Shipping price:&nbsp$'.$row['shippingprice'].'</span></b><br><br>';
            }
            else{
                echo '<span style="color:#696969">'.$row['shippinginfo'].'</span><br>';
                echo '<b><span style="color:black" size="3px">Free shipping</span></b><br><br>';
            }
            $today = date('Y-m-d');
            $todaystamp = strtotime($today);
            $thisyear = substr($today,0,4);
            $theenddate = substr($tmp['end_time'], 0, 10);
            $theendyear = substr($tmp['end_time'], 0, 4);
            $theendmonandday = substr($tmp['end_time'], 5, 5);
            $theendhour = substr($tmp['end_time'], 10, 20);
            $theenddatestamp = strtotime($theenddate);
            $theendtime = substr($tmp['end_time'], 11, 20);
            if($today == $theenddate){
            echo '<span style="color:#DC143C" size="3px">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                               &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                               End time:&nbsp&nbsp(Today)&nbsp&nbsp'.$theendtime.'</span><br>';
            }
            else{
                if($theenddatestamp - $todaystamp == 86400){
                    echo '<span style="color:#DC143C" size="3px">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                       &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                       End time:&nbsp(Tomorrow)'.$theendtime.'</span><br>';
                }
                else{
                    if($thisyear == $theendyear){
                        echo '<span style="color:#DC143C" size="3px">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                           &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                           End time:&nbsp&nbsp'.$theendmonandday.'</span>';
                        echo '<span style="color:#DC143C" size="3px">&nbsp&nbsp&nbsp&nbsp&nbsp'.$theendhour.'</span><br>';
                    }
                    else{
            echo '<span style="color:#DC143C" size="3px">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                               &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                               End time:&nbsp&nbsp'.$tmp['end_time'].'</span><br>';
                    }
                }
            }
            echo '<br>';
            echo '<span style="color:#DC143C" size="3px">'.$tmp['numofbidder'].'&nbspbids</span>';
            echo '<span style="color:#DC143C" size="3px">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													Status:&nbsp&nbsp</span>';
			if($tmp['status'] == 0)/*on auction*/
			{
            	echo '<span style="color:#DC143C" size="3px">On auction</span><br>';
			}
			else
			{
				if($tmp['status'] == 1)
				{
            		echo '<span style="color:#DC143C" size="3px">Sold</span><br>';
				}
				else
				{
            		echo '<span style="color:#DC143C" size="3px">Auction failed</span><br>';
				}
			}
            echo '</div>';
            echo '</div>';
            echo '</p>';
            echo '<p style="font-family:arial,sans-serif;text-decoration:none;text-align:left;padding-left:300px;">';
            echo "<br><br><br>";
            echo "<br><br><br>";
            echo "<br><br><br>";
            echo "<br><br><br>";
    echo '<span style="color:#D3D3D3">';
    echo "_________________________________________________________________________________________</span>";
        }
	}
}
mysqli_close($conn);
?>
</p>
</body>
</html>

