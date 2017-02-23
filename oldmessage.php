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
echo '<center>';
echo '<br/>';
echo '<a href="index.php" style="font-size:30pt;color:blue;text-decoration:none"><img src="amabae.png"></a><br/>';
echo '<div style="font-family:arial,sans-serif;font-size:20pt">Message Center</div><br/>';
echo '</center>';
include "dbconnect2.php";
$query = mysqli_query($conn, "update Message set status=0 where toname = '$username'");
header('Location:message.php');
/*
echo '<div style="font-family:arial,sans-serif;font-size:14pt;color:red">No New Message</div><br/><br/>';*/
/********************************************history message******************************************/
/*echo '<div style="font-family:arial,sans-serif;font-size:14pt;color:blue">Old Message</div><br/>';
$query = mysqli_query($conn, "select MessageID, sendtime, fromname, toname, message, title, status from Message where toname = '$username' and status=0 order by sendtime desc");
echo '<center style="font-family:arial,sans-serif;font-size:11pt;text-align:left;padding-left:50px;">';
echo "<table border='1' style='font-family:arial,sans-serif;font-size:10pt;word-break:break-all; word-wrap:break-all'>
<tr>
<th style=\"width:200px\">Sender</th>
<th style=\"width:130px\">Time</th>
<th style=\"width:130px\">Title</th>
<th style=\"width:800px\">Message</th>
</tr>";
while($row = mysqli_fetch_array($query))
{
   echo "<tr>"; 
   echo "<td style=\"width:200px\">".$row['fromname']."</td>";
   echo "<td style=\"width:130px\">".$row['sendtime']."</td>";
   echo "<td style=\"width:130px\">".$row['title']."</td>";
   echo "<td style=\"width:700px\">".$row['message']."</td>";
   echo "</tr>";
}
echo "</table>";
*/
mysqli_close($conn);
?>
