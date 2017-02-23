<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae auction item upload</title>
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
input[type=submit]{
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
<span style="font-size:28px;">Upload products on auction</span>
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
$_SESSION['uname'] = $username;
$_SESSION['uid'] = $userid;
$myitemid = $_GET['itemid'];
$uptypes=array(  
    'image/jpg',  
    'image/jpeg',  
    'image/png',  
    'image/pjpeg',  
    'image/gif',  
    'image/bmp',  
    'image/x-png'  
);  
$destination_folder="image/"; 
echo '</br>
<div style="font-family:arial,sans-serif;width:400px;font-size:11pt;text-decoration:none;text-align:left;padding-left:200px;word-wrap: break-word; word-break: break-all"">
<form enctype="multipart/form-data" method="post" name="upform">  
<b>Picture upload</b><font color="red">*</font><br/><br/>
<input name="upfile" style="font-size:13pt;width:px;height:30px" type="file"><br/><br/>
<i>(Acceptable type:&nbsp&nbspjpg, jpeg, png, pjpeg, gif, bmp)</i><br/><br/><br/><br/>
<input type="submit" style="width:100px;" value="upload">
</form>  
</div>';
echo '<p style="font-family:arial,sans-serif;color:red;font-size:11pt;text-decoration:none;text-align:center;padding-left:px;">';
if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{  
   /* if (!is_uploaded_file($_FILES["upfile"][tmp_name]))  
    
    {  
         echo "Picture does not exist!";  
         exit;  
    }  */
  
    $file = $_FILES["upfile"];  
  
    if(!in_array($file["type"], $uptypes))  
    
    {  
        echo "Type is not acceptable!".$file["type"];  
        exit;  
    }
  
  
    $filename=$file["tmp_name"];  
    $image_size = getimagesize($filename);  
    $pinfo=pathinfo($file["name"]);  
    $ftype=$pinfo['extension'];  
	$picname=$myitemid.".".$ftype;
    $destination = $destination_folder.$myitemid.".".$ftype;  
    if(!move_uploaded_file ($filename, $destination))  
    {  
        echo "Cannot rename picture";  
        exit;  
    } 
	include "dbconnect2.php";
	mysqli_query($conn, "update Items set picture = '$destination' where ItemID = '$myitemid'");
    mysqli_close($conn);
	header('Location: auctionitemuploadresult.php');
}  
echo '</p>';
/*************************************************************************************/
?>
</html>
