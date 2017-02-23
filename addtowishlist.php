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
$itemid = $_GET['itemid'];
$wishdate = date('Y-m-d');
/*echo $itemid;
echo $wishdate;
echo $userid;*/
include "dbconnect2.php";
$testquery = mysqli_query($conn, "select count(*) from Wishlist where UserID = '$userid' and ItemID = '$itemid'");
$temprow = mysqli_fetch_array($testquery);
if($temprow[0] > 0){/*have added*/
	echo '<center>';
    echo '<br/><br/>';
    echo '<p style="font-family:arial,sans-serif;font-size:20pt;color:red">You have already added this product into your wishlist!<br/><br/>';
    echo '<a href="singlesaleitem.php?itemid='.$itemid.'"  style="font-size:14pt;color:blue;text-decoration:none">Go back</a>';
    echo '&nbsp&nbsp&nbsp&nbsp&nbsp<a href="mywishlist.php"  style="font-size:14pt;color:blue;text-decoration:none">Go to wishlist</a>';
    echo '</center>';	
}
else{
	/*$wishquery = mysqli_query("select MAX(WishID) from Wishlist",$con);
	$maxwish = mysqli_result($wishquery,0);
	$wishid = $maxwish + 1;*/
	$addsql = "insert into Wishlist(ItemID, UserID, wishtime) values('$itemid','$userid','$wishdate')";
	if(!mysqli_query($conn, $addsql))
	{
		echo '<center>';
		echo '<br/><br/>';
    	echo '<p style="font-family:arial,sans-serif;font-size:20pt;color:red">Cannot add to wishlist<br/><br/>';
		echo '</center>';
		mysqli_close($conn);
		exit;
	}
	else{
		mysqli_close($conn);
		echo '<center>';
		echo '<br/><br/>';
    	echo '<p style="font-family:arial,sans-serif;font-size:24pt;color:red">Add to wishlist successfully!<br/><br/>';
    	echo '<a href="index.php"  style="font-size:14pt;color:blue;text-decoration:none">OK</a>';
    	echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="mywishlist.php"  style="font-size:14pt;color:blue;text-decoration:none">Go to wishlist</a>';
		echo '</p>';
		echo '</center>';
	}
}
?> 
