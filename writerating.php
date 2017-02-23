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
$orderid = $_POST['orderid'];
$source = $_POST['source'];
$score = $_POST['score'];
$seller = $_POST['seller'];
$comment1 = $_POST['comment'];
$comment = addslashes($comment1);
$_SESSION['uname'] = $username;
$_SESSION['uid'] = $userid;
$comtime = date('Y-m-d H:i:s');
/*echo $username;
echo '<br/>';
echo $orderid;
echo '<br/>';
echo $source;
echo '<br/>';
echo $score;*/
/*if($source == 0){
}
else{
}*/
/****************************************************************************************************************/
include "dbconnect2.php";
$existsql = "select count(*) from Rating where OrderID = '$orderid'";
$theresult = mysqli_query($conn, $existsql);
$theresultrow = mysqli_fetch_array($theresult);
$thenum = $theresultrow[0];
if($thenum != 0){
        echo '<br/><br/><br/><br/><br/><br/>';
        echo '<center>';
        echo '<span style="font-size:20pt;color:red">You have already reviewed!</span><br/><br/>';
		echo '<a href="myorder.php" style="font-size:20pt;color:blue;text-decoration:none">OK</a><br/>';
        echo '</center>';
        exit;   
}
else{
$sql = "update Orders set status = 4 where OrderID='$orderid'";
$query = mysqli_query($conn, $sql);
$countquery = mysqli_query($conn, "select count(*) from Rating");
$countqueryrow = mysqli_fetch_array($countquery);
$ratcount = $countqueryrow[0];
$newrateid = $ratcount + 1;
$sql2 = "insert into Rating(RatingID, OrderID, source, buyer, seller, comment_time, score, comment) values('$newrateid','$orderid','$source','$userid','$seller','$comtime','$score','$comment')";
$query2 = mysqli_query($conn, $sql2);
$sql3 = "select avg(score) from Rating where seller = '$seller'";
$avgquery = mysqli_query($conn, $sql3);
$avgqueryrow = mysqli_fetch_array($avgquery);
$avgscore = $avgqueryrow[0];
$sql4 = "update Users set rating = '$avgscore' where UserID = '$seller'";
mysqli_query($conn, $sql4);
mysqli_close($conn);
header('Location: myorder.php');
}
?>
