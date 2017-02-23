<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae message</title>
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
input[type=text], input[type=date], input[type=time] {
  display:inline-block;
  padding:3px 0;
  border:1px solid #aaa;
  border-radius:3px;
  border-sizing:border-box;
}
input[type=submit] {
  display:inline-block;
  padding:8px 15px;
  border:none;
  border-radius:3px;
  background-color:#4CAF50;
  color:white;
  cursor:pointer;
}
input[type=submit]:hover {
  background-color:#45A049;
}
</style>
</head>

<body>
<p style="text-align:center">
<a style="color:blue;" class="pagename" href="index.php">amabae</a><br>
<span style="font-size:28px;">Send Message</span>
</p>
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
$toname = $_GET['sellername'];
$itemname = $_GET['itemname'];
/*echo $toname;
echo '<br/>';
echo $itemname;
echo $username;
echo '<br/>';
echo $userid;
echo '<br/>';
echo $saleitemid;
echo '<br/>';*/
echo '<br/>';
echo '<div style="width:60%;margin:auto">';
echo '<form action="writeusermessage.php" method="post">';
echo '<b>To:</b>&nbsp&nbsp&nbsp<input type="text" name="toname" value = '.$toname.' /><br/><br/>';
echo '<b>Title:</b><br/><br/><input type="text" name="title" style="width:600px;" value = "'.$itemname.'"><br/><br/>';
echo '<b>Message:</b><br/><br/><textarea name="message" cols ="83" rows = "10"></textarea><br/><br/><br/>';
echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    <input type="submit" style="margin-left:10%;width:200px" value="Send message" />';
echo '</form>';
echo "</div>";
?>
</body>
</html> 
