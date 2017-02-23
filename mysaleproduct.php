<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Amabae</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scala=1">
<style>

div{float:left}
input[type=text] {
  display:inline-block;
  width:350px;
  padding:8px 0;/*very important keep input field center*/
  border:1px solid #aaa;
  border-radius:3px;
  border-sizing:border-box;
}
input[type=submit],input[type=button] {
  display:inline-block;
  padding:8px 18px;
  border:none;
  border-radius:3px;
  background-color:#4CAF50;
  color:white;
  font-size:14px;
  cursor:pointer;
}
input[type=submit]:hover,input[type=button]:hover {
  background-color:#45A049;
}
ul#topbar {
    list-style-type: none;
    position:fixed;
    width:100%;
    height:50px;
    margin: 0;
    padding: 0;
    overflow:;
    background-color: #444;
    font-size:12px;
}

ul#topbar > li { 
    float: right;
}

ul#topbar > li a {
    display: block;
    color: white;
    text-align: center;
    padding: 18px 16px;
    text-decoration: none;
}

ul#topbar > li a:hover {
    background-color: #111;
}

ul#navigate {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 200px;
    background-color: #f1f1f1;
    position: fixed;
    top:50px;
    height: 100%;
    overflow: auto;
}
ul#navigate > li a {
    display: inline-block;
    width:100%;
    color: #000;
    padding: 2px 10px;
    text-decoration: none;
}
ul#navigate > li a.active {
    background-color: #4CAF50;
    color: white;
}
ul#navigate > li a:hover:not(.active) {
    background-color: #777;
    color: white;
}
div.dropdown{
  display:none;
  position:fixed;
  //top:50px;
  width:200px;
  right:91px;
  background-color:#f1f1f1;
}
ul#topbar > li.user:hover div.dropdown{
  display:block;
  z-index:1;
}
ul#topbar > li.user:hover div.dropdown a{
  diaplay:block;
  text-align:left;
  padding:5px 10px;
  color:black;
}
ul#topbar > li.user:hover div.dropdown a:hover{
  background-color:#444;
  color:white;
}
</style>
</head> 
<body style="margin:0;font-family:arial,sans-serif;font-size:15px">
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
$itemid=$_GET['itemid'];
$_SESSION['saleitemid'] = $itemid;
/**************/
echo '
<ul id="topbar">
<li style="float:left"><a style="font-size:30px;padding:8px 30px;" class="pagename" href="index.php">amabae</a></li>';

echo '<li>  ';
include "dbconnect2.php";
    $query = mysqli_query($conn, "select count(*) from Message where toname = '$username' and status = 1");
	$row = mysqli_fetch_array($query);
    $count = $row[0];
    $_SESSION['messagecount'] = $count;
    if($count){
        echo '<a href="message.php">You have ';
        echo "<span style='color:red'>$count</span>";
        echo ' new message</a>';
    	//echo '<audio autoplay><source src="newmessage.mp3"></audio>';
    	//echo '<audio autoplay><source src="women.wav"></audio>';
    }
    else{
        echo '<a href="message.php">You have 0 new message</a>';
    }
    mysqli_close($conn);
echo '</li>';

echo '<li class="user" style="padding:0 0 0 40px">
<a href="index.php">Hi, '.$username.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&#9662</a>
<div class="dropdown">
<a href="userinfo.php">edit my information</a>
<a href="myorder.php">my order</a>
<a href="mywishlist.php">my wishlist</a>
<a href="myselling.php">my selling</a>
<a href="myproduct.php">my products</a>
<a href="checkreview.php">who review me</a>
<a style="cursor:default;background-color:#f1f1f1;color:black;font-weight:bold">I want to sell</a>
<a href="saleitem.php">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspwith fixed price</a>
<a href="auctionitem.php">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspby auction</a>
<a href="signout.php">sign out</a>
</div>
</li>';

echo '
<li style="margin-right:80px;padding:7px">
<form action="search.php" method="get">
<input type="text" name="searchvalue">
<input style="font-size:12px" type="submit" value="Search">
</form>
</li>';

echo '</ul>';
echo '<br/><br/>';
include "dbconnect2.php";
$sql="select I.item_name,I.picture,I.description,I.shippinginfo,I.shippingprice,I.quantity,I.location,I.uploadtime,S.saleitemsource,S.price,S.supplierid,S.sellerid,S.soldquantity from Items I, Sale_items S Where I.ItemID = '$itemid' and I.ItemID = S.ItemID ";
$saleitem = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($saleitem);
$location = $row['location'];
$description = $row['description'];
/******************************************************************************************************************************/
echo '<p style="font-family:arial,sans-serif;font-size:11pt;text-decoration:none;text-align:left;padding-left:10px;">';
echo "<br/><br/>";
echo '<img style="float:left;padding-left:100px;" align = "top" src="'.$row['picture'].'"  width="300"  alt="No images available" />';
echo '<div style="font-size:12pt;width:500px;table-layout:fixed;text-align:top;padding-left:50px;word-wrap: break-word; word-break: break-all">';
echo'<span style="font-size:14pt;font-weight:bold;width;text-decoration:none;table-layout: fixed;text-align:top;word-wrap: break-word; word-break: break-all">'.$row['item_name'].'</span><br/>';
echo '<font color="#D3D3D3">';
echo "________________________________________________________</font><br/><br/>";
if($row['saleitemsource'] == 0)/*from supplier*/
{
    echo '<font color="#696969">From supplier xxx</font><br/>';
}
else
{
    echo '<font color="#696969">From individual</font><br/>';
}
echo '<b><font color="black" size="5px">$'.$row['price'].'</font></b><br/><br/>';
if($row['shippingprice'])/*not free shipping*/
{
    echo '<font color="#696969">'.$row['shippinginfo'].'</font><br/>';
    echo '<b><font color="black" size="3px">Shipping price:&nbsp$'.$row['shippingprice'].'</font></b><br/>';
}
else{
    echo '<font color="#696969">'.$row['shippinginfo'].'</font><br/>';
    echo '<b><font color="black" size="3px">Free shipping</font></b><br/>';
}
echo '<b><font color="black" size="3px">Ship from:&nbsp'.$location.'</font></b>';
echo '<br/><br/>';
echo '<font color="#696969">'.$row['quantity'].'&nbsp&nbspleft</font><br/><br/><br/>';
echo '<font color="#696969">Upload time:&nbsp&nbsp'.$row['uploadtime'].'</font>';
echo '&nbsp&nbsp&nbsp<input type="button" value="Go back"   onclick="javascript:window.history.back();">';
echo '<br/><br/><br/>';
echo '</div>';
echo '</p>';
echo '<p style="font-family:arial,sans-serif;font-size:11pt;text-decoration:none;text-align:top;padding-top:20px">';
echo '<font color="#D3D3D3">';
echo "_________________________________________________________________________________________________________________________</font><br/><br/>";
echo '<font size=3pt><b>Description</b></font>';
echo '<div style="font-size:12pt;width:600px;table-layout:fixed;text-align:top;padding-left:100px;word-wrap: break-word; word-break: break-all">';
echo $description;
echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
echo '</div>';
echo '</p>'; 
mysqli_close($conn);
/*****************************************************************************************************************/
?>
</body>
</html> 
