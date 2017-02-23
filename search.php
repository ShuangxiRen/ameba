<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Amabae search</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scala=1">
<style>
table {
  width:100%;
  border:1px solid #ffffff;
  border-collapse:collapse;
}
tr.item {
  border-bottom:1px solid #ccc;
}
td {
  padding-top:15px;
}
td.picture {
  width:120px;
  float:left;
}
td.descr {
  padding-left:40px;
  padding-bottom:30px;
  display:inline-block;
}
img {
  width:120px;
  height:auto;  
}
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
    padding: 10px 0;
    width: 200px;
    background-color: #f1f1f1;
    position: fixed;
    top:50px;
    height: 100%;
    overflow: auto;
    font-size:13px;
}
ul#navigate > li a {
    display: block;
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
<input type="text" name="searchvalue" >
<input style="font-size:12px" type="submit" value="Search" >
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
?>


<br>
<br> 
<ul id="navigate">
<li><a class="category" href="category.php?categoryid=0" style="font-weight:bold;">ALL</a></li>                
<li><a class="category" href="category.php?categoryid=1" style="font-weight:bold;">&nbsp&nbspElectronics</a></li>
<li><a class="category" href="category.php?categoryid=2" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCell phones</a></li>
<li><a class="category" href="category.php?categoryid=3" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSmartpnone</a></li>
<li><a class="category" href="category.php?categoryid=4" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAccessories</a></li>
<li><a class="category" href="category.php?categoryid=5" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspComputer</a></li>
<li><a class="category" href="category.php?categoryid=6" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspLaptop</a></li>             
<li><a class="category" href="category.php?categoryid=7" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTablets</a></li>         
<li><a class="category" href="category.php?categoryid=8" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDesktop</a></li>    
<li><a class="category" href="category.php?categoryid=9" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspParts</a></li>
<li><a class="category" href="category.php?categoryid=10" style="font-weight:bold;">&nbsp&nbspClothing&Shoes</a></li>
<li><a class="category" href="category.php?categoryid=11" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspWomen</a></li>
<li><a class="category" href="category.php?categoryid=12" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspJeans</a></li>               
<li><a class="category" href="category.php?categoryid=13" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCoats</a></li>          
<li><a class="category" href="category.php?categoryid=14" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspShoes</a></li>     
<li><a class="category" href="category.php?categoryid=15" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMen</a></li>
<li><a class="category" href="category.php?categoryid=16" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspJeans</a></li>            
<li><a class="category" href="category.php?categoryid=17" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspT-shirts</a></li>               
<li><a class="category" href="category.php?categoryid=18" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspShoes</a></li>       
<li><a class="category" href="category.php?categoryid=19" style="font-weight:bold;">&nbsp&nbspAppliances</a></li>
<li><a class="category" href="category.php?categoryid=20#20" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspKitchen</a></li>
<li><a class="category" href="category.php?categoryid=21#21" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMicrowave</a></li>              
<li><a class="category" href="category.php?categoryid=22#22" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFrigerator</a></li>      
<li><a class="category" href="category.php?categoryid=23#23" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspBurner</a></li>
<li><a class="category" href="category.php?categoryid=24#24" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspLivingroom</a></li>
<li><a class="category" href="category.php?categoryid=25#25" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTV</a></li>
<li><a class="category" href="category.php?categoryid=26#26" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAirconditioner</a></li>
<li><a class="category" href="category.php?categoryid=27#27" style="font-weight:bold;">&nbsp&nbspBooks</a></li>
<li><a class="category" href="category.php?categoryid=28#28" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTextbooks</a></li>
<li><a class="category" href="category.php?categoryid=29#29" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspEducation</a></li>
<li><a class="category" href="category.php?categoryid=30#30" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspComputer&nbspScience</a></li>
<li><a class="category" href="category.php?categoryid=31#31" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSocial Science</a></li>
<li><a class="category" href="category.php?categoryid=32#32" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMagazines</a></li>
<li><a class="category" href="category.php?categoryid=33#33" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFashion&Style</a></li>
<li><a class="category" href="category.php?categoryid=34#34" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCooking</a></li>
<li><a class="category" href="category.php?categoryid=35#35" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspChildren's Books</a></li>
<li><a class="category" href="category.php?categoryid=36#36" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspGames</a></li>
<li><a class="category" href="category.php?categoryid=37#37" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAnimals</a></li>
<li><a class="category" href="category.php?categoryid=38#38" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspEarly Learning</a></li>
<li>&nbsp</li>
<li>&nbsp</li>
<li>&nbsp</li>
<li>&nbsp</li>
<li>&nbsp</li>
<br><br><br>
</ul>

<?php
include "dbconnect2.php";
$search = "%$searchvalue%";
$item = mysqli_query($conn, "select  I.ItemID,C.category_name,I.item_name,I.picture,I.description,I.shippinginfo,I.shippingprice,I.location from Items I, Categories C Where I.quantity > 0 and I.category = C.CategoryID and I.item_name like '$search' order by I.item_name ASC");
echo '<div style="font-size:14px;padding:0px;margin:50px 10% 0 300px;">';//whole item page
echo '<table>';//whole item page
while($row = mysqli_fetch_array($item))
{
    $itemname = $row['item_name'];
	$itemid = $row['ItemID'];
	$sql = "select ItemID from Sale_items where ItemID = '$itemid'";
	$query = mysqli_query($conn, $sql);
	$queryrow = mysqli_fetch_array($query);
	$result = $queryrow[0];
	if($result)/*fixed price*/
	{
		echo '<tr class="item">';
		
		echo '<td class="picture">';
		echo '<img src="'.$row['picture'].'" alt="No images available" >';
		echo '</td>';//picture div
		
		echo '<td class="descr">';
		echo'<a href="singlesaleitem.php?itemid='.$itemid.'" style="display:block;text-decoration:none;color:blue;max-width:300px;">'.$itemname.'</a><br>';
		$sql = "select price,supplierid,sellerid,soldquantity from Sale_items where ItemID = '$itemid'";
		$query = mysqli_query($conn, $sql);
		$tmp = mysqli_fetch_array($query);
		if($tmp['supplierid'])/*from supplier*/
		{
			$supsql = "select S1.compname from Suppliers S1, Sale_items S2 where S2.ItemID = '$itemid' and S1.SupplierID = S2.supplierid";
    	$supquery = mysqli_query($conn, $supsql);
			$supqueryrow = mysqli_fetch_array($supquery);
    	$suppliername = $supqueryrow[0];
			echo '<span style="color:#696969">From supplier&nbsp'.$suppliername.'</span><br>';
		}
		else
		{
			echo '<span style="color:#696969">From individual</span><br>';
		}
		echo '<span style="font-weight:bold;font-size:25px">$'.$tmp['price'].'</span><br>';
		echo '<span style="color:#696969">By it now</span><br><br>';
		if($row['shippingprice'])/*not free shipping*/
		{
			echo '<span style="color:#696969">'.$row['shippinginfo'].'</span><br>';
			echo '<span style="font-weight:bold;font-size:15px">Shipping price:&nbsp$'.$row['shippingprice'].'</span><br>';
		}
		else{
			echo '<span style="color:#696969">'.$row['shippinginfo'].'</span><br>';
			echo '<span style="font-weight:bold;font-size:15px">Free shipping</span><br>';
		}
		echo '<br>';
		echo '<span style="color:#DC143C">'.$tmp['soldquantity'].'&nbspsold</span><br>';
		echo '</td>';//descr div 
		
		echo '</tr>';//item div
	}	

  else/*auction item*/ 
  {
    echo '<tr class="item">';
    $sql = "select sellerid,reserve_price,end_time,numofbidder,status from Auction_items where ItemID = '$itemid'";
    $query = mysqli_query($conn, $sql);
    $tmp = mysqli_fetch_array($query);
	  $nowtime = date('Y-m-d H:i:s');
    if($tmp['status'] != 0 || $tmp['end_time'] < $nowtime)/*not on auction*/
    {       
    }       
    else    
    {
      echo '<td class="picture">';       
		  echo '<img src="'.$row['picture'].'"  alt="No images available" >';
		  echo '</td>';//picture div
		  
		  echo '<td class="descr">';
    	echo'<a href="singleauctionitem.php?itemid='.$itemid.'" style="display:block;color:blue;max-width:300px;text-decoration:none;">'.$itemname.'</a><br>';
    	echo '<span style="color:#696969">On auction</span><br><br>';
    	if($row['shippingprice'])/*not free shipping*/
    	{       
        	echo '<span style="color:#696969">'.$row['shippinginfo'].'</span><br>';
        	echo '<span style="font-weight:bold;font-size:15px">Shipping price:&nbsp$'.$row['shippingprice'].'</span><br><br>';
    	}       
    	else{   
        	echo '<span style="color:#696969">'.$row['shippinginfo'].'</span><br>';
        	echo '<span style="font-weight:bold;font-size:15px">Free shipping</span><br><br>';
    	}       
		  $today = date('Y-m-d');
		  $todaystamp = strtotime($today);
		  $thisyear = substr($today,0,4);
		  $theenddate = substr($tmp['end_time'], 0, 10);
		  $theendyear = substr($tmp['end_time'], 0, 4);
		  $theendmonandday = substr($tmp['end_time'], 5, 5);
		  $theendhour = substr($tmp['end_time'], 10, 20);
		  $theenddatestamp = strtotime($theenddate);
		  $theendtime = substr($tmp['end_time'], 11, 20);
		  if($today == $theenddate){
      	echo '<span style="color:#DC143C">
      	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				End time:&nbsp&nbsp(Today)&nbsp&nbsp'.$theendtime.'</span><br>';
		  }
		  else{
			  if($theenddatestamp - $todaystamp == 86400){
      		echo '<span style="color:#DC143C">
      		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					End time:&nbsp(Tomorrow)&nbsp'.$theendtime.'</span><br>';
			  }
			  else{
				  if($thisyear == $theendyear){
      			echo '<span style="color:#DC143C">
      			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						End time:&nbsp&nbsp'.$theendmonandday.'</span>';
      		  echo '<span style="color:#DC143C">&nbsp&nbsp&nbsp&nbsp&nbsp'.$theendhour.'</span><br>';
				  }
				  else{
      	    echo '<span style="color:#DC143C">
      	    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						End time:&nbsp&nbsp'.$tmp['end_time'].'</span><br>';
				  }
			  }
		  }
      echo '<br>';
      echo '<span style="color:#DC143C">'.$tmp['numofbidder'].'&nbspbids</span><br>';
		  echo '</td>';//descr div
		  
		  echo '</tr>';//item div
  	}
	}
}
echo '</div>';
mysqli_close($conn);
?>
</body>
</html> 
