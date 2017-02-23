<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae message center</title>
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
button {
  display:inline-block;
  padding:8px 10px;
  border:none;
  border-radius:3px;
  background-color:#4CAF50;
  color:white;
  cursor:pointer;
}
button:hover {
  background-color:#45A049;
}
table {
  margin:auto;
  width:100%;
  border-collapse:collapse;
  font-size:12px;
}
th {
  height:30px;
  text-align:left;
  color:white;
  background-color:#4caf50;
}
tr:nth-child(even){
  background-color:#f2f2f2;
}
td {
  padding:10px 0;
}
tr:hover{
  background-color:#ddd;
}
</style>
</head>

<body>
<p style="text-align:center">
<a style="color:blue;" class="pagename" href="index.php">amabae</a><br>
<span style="font-size:28px;">Message Center</span>
</p> 
<?php
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
include "dbconnect2.php";
$numquery = mysqli_query($conn, "select count(*) from Message where toname = '$username' and  status = 1");
$numqueryrow = mysqli_fetch_array($numquery);
$mcount = $numqueryrow[0];
if($mcount > 0){
echo '<div style="font-size:14pt;color:red">New Message</div><br/>';
$query = mysqli_query($conn, "select MessageID, sendtime, fromname, toname, message, title, status from Message where toname = '$username' and status=1 order by sendtime desc");
echo "<table>
<tr>
<th style='width:200px'>Sender</th>
<th style='width:130px'>Time</th>
<th style='width:130px'>Title</th>
<th style='width:800px'>Message</th>
</tr>";
while($row = mysqli_fetch_array($query))
{
   echo "<tr>"; 
   echo "<td style='width:200px'>".$row['fromname']."</td>";
   echo "<td style='width:130px'>".$row['sendtime']."</td>";
   echo "<td style='width:130px'>".$row['title']."</td>";
   echo "<td style='width:700px'>".$row['message']."</td>";
   echo "</tr>";
}
echo "</table><br/>";

echo '<form action="oldmessage.php" method="get">
<button type="subject" style="margin-left:35%;width:250px;">I have read the new messages</button>
</form>';
/********************************************history message******************************************/
echo '<div style="font-family:arial,sans-serif;font-size:14pt;color:blue">Old Message</div><br/>';
$query = mysqli_query($conn, "select MessageID, sendtime, fromname, toname, message, title, status from Message where toname = '$username' and status=0 order by sendtime desc");
echo "<table>
<tr>
<th style='width:200px'>Sender</th>
<th style='width:130px'>Time</th>
<th style='width:130px'>Title</th>
<th style='width:700px'>Message</th>
</tr>";
while($row = mysqli_fetch_array($query))
{
   echo "<tr>"; 
   echo "<td style='width:200px'>".$row['fromname']."</td>";
   echo "<td style='width:130px'>".$row['sendtime']."</td>";
   echo "<td style='width:130px'>".$row['title']."</td>";
   echo "<td style='width:700px'>".$row['message']."</td>";
   echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
}
else{/*all are old messages*/
echo '<div style="font-size:14pt;color:red">NO New Message</div><br/><br/>';
/********************************************history message******************************************/
echo '<div style="font-family:arial,sans-serif;font-size:14pt;color:blue">Old Message</div><br/>';
$query = mysqli_query($conn, "select MessageID, sendtime, fromname, toname, message, title, status from Message where toname = '$username' and status=0 order by sendtime desc");
echo "<table>
<tr>
<th style='width:200px'>Sender</th>
<th style='width:130px'>Time</th>
<th style='width:130px'>Title</th>
<th style='width:700px'>Message</th>
</tr>";
while($row = mysqli_fetch_array($query))
{
   echo "<tr>"; 
   echo "<td style='width:200px'>".$row['fromname']."</td>";
   echo "<td style='width:130px'>".$row['sendtime']."</td>";
   echo "<td style='width:130px'>".$row['title']."</td>";
   echo "<td style='width:800px'>".$row['message']."</td>";
   echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
}
?>
</body>
</html> 
