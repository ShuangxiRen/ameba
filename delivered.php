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
$orderid = $_GET['ORDERID'];
$_SESSION['uname'] = $username;
$_SESSION['uid'] = $userid;
echo $username;
echo $orderid;
/****************************************************************************************************************/
include "dbconnect2.php";
$sql = "update Orders set status = 3 where OrderID='$orderid'";
$query = mysqli_query($conn, $sql);
header('Location: myorder.php');
?>