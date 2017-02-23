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
$toname = $_POST['toname'];
$title1 = $_POST['title'];
$message1 = $_POST['message'];
$fromname = $username;
$_SESSION['uname'] = $username;
$_SESSION['uid'] = $userid;
$title = addslashes($title1);
$message = addslashes($message1);
include "dbconnect2.php";
$query1= mysqli_query($conn, "select count(*) from Users where username='$toname'");
$query1row = mysqli_fetch_array($query1);
$theresult = $query1row[0];
if($theresult == 0){
   	echo '<center>';
 	echo'<br/><br/><br/><br/><br/><br/>';
   	echo'<span style="font-size:20pt;color:red">"'.$toname.'"&nbsp&nbspis not an Amabae user!</span><br/><br/>';
	echo '<a href="usermessage.php?sellername='.$toname.'&itemname='.$title1.'" style="font-family:arial,sans-serif;font-size:20pt;color:blue;text-decoration:none">OK</a><br/>';
    echo '</center>';
	mysqli_close($conn);
	exit;
}
$retitle = "RE:&nbsp".$title;
$wholemessage=$message."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href=\"usermessage.php?sellername=".$username."&itemname=".$retitle."\" style=\"font-family:arial,sans-serif;font-size:11pt;color:blue;text-decoration:none\">Reply</a>";
$realmessage = addslashes($wholemessage);
$nowtime = date('Y-m-d H:i:s');
$query = mysqli_query($conn, "select MAX(MessageID) from Message");
$queryrow = mysqli_fetch_array($query);
$result = $queryrow[0];
$newmessageid = $result + 1;
$sellermesql = "insert into Message(MessageID, sendtime, type, fromname, toname, title, message, status) values('$newmessageid','$nowtime','1','$fromname','$toname','$title','$realmessage','1')";
if(!mysqli_query($conn, $sellermesql))
{
   	echo '<center>';
 	echo'<br/><br/><br/><br/><br/><br/>';
   	echo'<span style="font-size:20pt;color:red">Send message failed!</span><br/><br/>';
    echo '</center>';
	mysqli_close($conn);
    exit;   
}
echo '<center>';
echo '<br/><br/>';
echo '<br/><br/>';
echo '<span style="font-size:25pt;color:red">Send message success!</span><br/><br/>';
echo '<a href="index.php" style="font-family:arial,sans-serif;font-size:20pt;color:blue;text-decoration:none">OK</a><br/>';
echo '</center>';
mysqli_close($conn);
?>
