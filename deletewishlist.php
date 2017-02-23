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
$itemid = $_GET['wishitemid'];
$_SESSION['uname'] = $username;
$_SESSION['uid'] = $userid;
/****************************************************************************************************************/
include "dbconnect2.php";
$sql = "delete from Wishlist where ItemID='$itemid' and UserID='$userid'";
$query = mysqli_query($conn, $sql);
mysqli_close($conn);

header('Location: mywishlist.php');
?>