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
input[type=submit] {
  display:inline-block;
  padding:8px 18px;
  border:none;
  border-radius:3px;
  background-color:#4CAF50;
  color:white;
  font-size:14px;
  cursor:pointer;
}
input[type=submit]:hover {
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
$itemid=$_GET['itemid'];
$_SESSION['auctionitemid'] = $itemid;
$searchvalue = $_GET['searchvalue'];
$username = $_SESSION['uname'];
$userid = $_SESSION['uid'];
$categoryid = $_GET['categoryid'];
if(!$_SESSION['uname']){
echo '
<ul id="topbar">
<li style="float:left"><a style="font-size:30px;padding:8px 30px;" class="pagename" href="index.php">amabae</a></li>
<li><a href="job/aboutme.html" style="font-weight:bold;color:red;text-decoration:none">Employer please click here</a></li>
<li style="margin-right:60px"><a href="signin.php" style="color:white;text-decoration:none">Sign in</a></li>
<li style="padding:0 0 0 40px"><a href="register.php" style="color:white;text-decoration:none;">Register</a></li>
<li style="margin-right:70px;padding:7px">
<form action="search.php" method="get">
<input type="text" name="searchvalue" />
<input style="font-size:12px" type="submit" value="Search">
</form>
</li>
</ul>
';
}else{
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
}
/**************************************/

/**************************************/
echo '<br/><br/>';
include "dbconnect2.php";
$sql="select I.item_name,I.picture,I.description,I.shippinginfo,I.shippingprice,I.location,A.reserve_price,A.end_time,A.numofbidder,A.SellerID,A.status from Items I, Auction_items A Where I.ItemID = '$itemid' and I.ItemID = A.ItemID ";
$auctionitem = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($auctionitem);
/******************************************************************************************************************************/
$nowtime = date('Y-m-d H:i:s');
echo '<p style="font-family:arial,sans-serif;font-size:11pt;text-decoration:none;text-align:left;padding-left:10px;">';
echo "<br/><br/>";
echo '<img style="float:left;padding-left:100px" align = "top" src="'.$row['picture'].'"  width="300"  alt="No images available" />';
echo '<div style="font-size:12pt;width:500px;table-layout:fixed;text-align:top;padding-left:50px;word-wrap: break-word; word-break: break-all">';
echo'<span style="font-size:14pt;font-weight:bold;width;text-decoration:none;table-layout: fixed;text-align:top;word-wrap: break-word; word-break: break-all">'.$row['item_name'].'</span><br/>';
echo '<font color="#D3D3D3">';
echo "________________________________________________________</font><br/><br/>";
$aucsellerid = $row['SellerID'];
$selquery = mysqli_query($conn, "select username, rating from Users where UserID = '$aucsellerid'");
$aucsellerrow = mysqli_fetch_array($selquery);
$aucseller = $aucsellerrow['username'];
$aucrating = $aucsellerrow['rating'];
$location = $row['location'];
$description = $row['description'];
$myitemname = $row['item_name'];
echo '<font color="#696969">From individual:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>'.$aucseller.'</b>&nbsp&nbsp<a href = "usermessage.php?sellername='.$aucseller.'&itemname='.$myitemname.'" style="font-size:12pt;color:blue;width:400px;text-decoration:none">Send message</a><br/>
													   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													   <b>Rating:</b>&nbsp&nbsp<font color=red>'.$aucrating.'</font>&nbsp&nbsp(0~10)</font><br/><br/>';
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
$today = date('Y-m-d');
$todaystamp = strtotime($today);
$thisyear = substr($today,0,4);
$theenddate = substr($row['end_time'], 0, 10);
$theendyear = substr($row['end_time'], 0, 4);
$theendmonandday = substr($row['end_time'], 5, 5);
$theendhour = substr($row['end_time'], 10, 20);
$theenddatestamp = strtotime($theenddate);
$theendtime = substr($row['end_time'], 11, 20);
if($today == $theenddate){
echo '<font color="#DC143C" size="3px">End time:&nbsp&nbsp(Today)&nbsp&nbsp'.$theendtime.'</font><br/>';
}
else{
    if($theenddatestamp - $todaystamp == 86400){
        echo '<font color="#DC143C" size="3px">End time:&nbsp(Tomorrow)'.$theendtime.'</font><br/>';
    }
    else{
        if($thisyear == $theendyear){
            echo '<font color="#DC143C" size="3px">End time:&nbsp&nbsp'.$theendmonandday.'</font>';
            echo '<font color="#DC143C" size="3px">&nbsp&nbsp&nbsp&nbsp&nbsp'.$theendhour.'</font><br/>';
        }
        else{
			echo '<font color="#DC143C" size="3px">End time:&nbsp&nbsp'.$tmp['end_time'].'</font><br/>';
        }
    }
}
echo '<br/>';
echo '<font color="#DC143C" size="3px">'.$row['numofbidder'].'&nbspbids</font><br/><br/>';
/*$bidderquery = mysqli_query($conn, "select U.username, B.money from Users U, Bidding B where B.ItemID = '$itemid' and B.bidder = U.UserID order by money DESC");
while($bidderrow = mysqli_fetch_array($bidderquery))
{
	echo $bidderrow['username'].":&nbsp&nbsp<b>$".$bidderrow['money']."</b><br/>";
}*/
$hquery = mysqli_query($conn, "select max(money) from Bidding where ItemID = '$itemid'");
$hqueryrow = mysqli_fetch_array($hquery);
$highest = $hqueryrow[0];

$resql = "select reserve_price, end_time from Auction_items where ItemID = '$auctionitemid'";
$requery = mysqli_query($conn, $sql);
$rerow = mysqli_fetch_array($query);
$reprice = $row['reserve_price'];
$youcan = $reprice > $highest? $reprice + 2 : $highest + 2;
echo "Current highest:&nbsp&nbsp<b>$".$highest."</b><br/><br/>";
echo '<form action="placebid.php" method="post">';
echo '$';
echo '<input type="text" style="width:150px" name="bidmoney" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
echo '<input type="submit"  value="Place bid" />';
echo '&nbsp&nbsp&nbsp<input  style="cursor:pointer;border:none;outline:none;background-color:white;color:blue;font-size:15px"';echo 'type="button" value="Back"   onclick="javascript:window.history.back();">';
echo '<br/>';
echo '<font size= 2pt>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspEnter&nbsp'.$youcan.'&nbspor more</font>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</p>';
echo '<p style="font-family:arial,sans-serif;font-size:11pt;text-decoration:none;text-align:top;padding-top:470px">';
echo '<font color="#D3D3D3">';
echo "_________________________________________________________________________________________________________________________</font><br/><br/>";
echo '<font size=3pt><b>Description</b></font>';
echo '<div style="font-size:12pt;width:600px;table-layout:fixed;text-align:top;padding-left:100px;word-wrap: break-word; word-break: break-all">';
echo $description;
echo '</div>';
echo '<br/><br/>';
echo '<font color="#D3D3D3">';
echo "_________________________________________________________________________________________________________________________</font><br/><br/>";
echo '<font size=3pt><b>Review</b></font><br/><br/>';
echo '<div style="font-size:12pt;width:600px;table-layout:fixed;text-align:top;padding-left:100px;word-wrap: break-word; word-break: break-all">';
$ratequery = mysqli_query($conn, "select R.comment_time, R.score, R.comment, O.bidornot, U.username, I.item_name from Rating R, Orders O, Users U, Items I where R.seller = '$aucsellerid' and R.OrderID = O.OrderID and R.buyer = U.UserID and O.ItemID = I.ItemID order by R.comment_time DESC");
while($row = mysqli_fetch_array($ratequery))
{
        $ratetime = $row['comment_time'];
        $reviewer = $row['username'];
        $product = $row['item_name'];
        $comment = $row['comment'];
        $myscore = $row['score'];
        if($row['bidornot'] == 0){
                $bustype = "Sale"; 
        }       
        else{   
                $bustype = "Auction";
        }       
        echo '<b>Review date:</b>&nbsp&nbsp'.$ratetime.'<br/><br/>';
        echo '<b>Reviewer:</b>&nbsp&nbsp'.$reviewer.'<br/><br/>';
        echo '<b>Business type:</b>&nbsp&nbsp'.$bustype.'<br/><br/>';
        echo '<b>Product:</b>&nbsp&nbsp'.$product.'<br/><br/>';
        echo '<b>Rating score:</b>&nbsp&nbsp'.$myscore.'<br/><br/>';
        echo '<b>Comment:</b>&nbsp&nbsp'.$comment.'<br/>';
    echo '<font color="#D3D3D3">';
    echo "__________________________________________________________________</font><br/><br/><br/>";
}
echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
echo '</div>';
echo '</p>';
mysqli_close($conn);
/*****************************************************************************************************************/
?>
</body>
</html> 
