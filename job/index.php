<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Amabae</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scala=1">
<style>
div.item {
  padding:0;
}

div.picture {
  width:120px;
  float:left;
}
div.descr {
  margin-left:40px;
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
    overflow:hidden;
    background-color:#444;
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
    font-size:12px;
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
</style>
</head> 
<body style="margin:0;font-family:arial,sans-serif;font-size:15px">
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
<li><a class="category" href="category.php?categoryid=20" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspKitchen</a></li>
<li><a class="category" href="category.php?categoryid=21" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMicrowave</a></li>              
<li><a class="category" href="category.php?categoryid=22" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFrigerator</a></li>      
<li><a class="category" href="category.php?categoryid=23" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspBurner</a></li>
<li><a class="category" href="category.php?categoryid=24" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspLivingroom</a></li>
<li><a class="category" href="category.php?categoryid=25" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTV</a></li>
<li><a class="category" href="category.php?categoryid=26" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAirconditioner</a></li>
<li><a class="category" href="category.php?categoryid=27" style="font-weight:bold;">&nbsp&nbspBooks</a></li>
<li><a class="category" href="category.php?categoryid=28" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTextbooks</a></li>
<li><a class="category" href="category.php?categoryid=29" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspEducation</a></li>
<li><a class="category" href="category.php?categoryid=30" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspComputer&nbspScience</a></li>
<li><a class="category" href="category.php?categoryid=31" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSocial Science</a></li>
<li><a class="category" href="category.php?categoryid=32" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMagazines</a></li>
<li><a class="category" href="category.php?categoryid=33" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFashion&Style</a></li>
<li><a class="category" href="category.php?categoryid=34" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCooking</a></li>
<li><a class="category" href="category.php?categoryid=35" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspChildren's Books</a></li>
<li><a class="category" href="category.php?categoryid=36" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspGames</a></li>
<li><a class="category" href="category.php?categoryid=37" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAnimals</a></li>
<li><a class="category" href="category.php?categoryid=38" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspEarly Learning</a></li>
<li>&nbsp</li>
<li>&nbsp</li>
<li>&nbsp</li>
<li>&nbsp</li>
<li>&nbsp</li>
</ul>
<?php
/*
	$con=mysqli_connect("127.0.0.1","root","thinker");
	if (!$con){
	echo '<center>';
	echo "Cannot connect database!";
	echo '</center>';
}*/
include "dbconnect2.php";
/*mysqli_select_db("newamabae");*/
echo '<div style="font-size:14px;margin:50px 10% 0 300px;">';//whole item page
$item = mysqli_query($conn, "select  I.ItemID,C.category_name,I.item_name,I.picture,I.description,I.shippinginfo,I.shippingprice,I.location from Items I, Categories C Where I.category = C.CategoryID order by I.item_name ASC");
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
		echo '<br><div class="item">';
		
		echo '<div class="picture">';
		echo '<img src="'.$row['picture'].'" alt="No images available" >';
		echo '</div>';//picture div
		
		echo '<div class="descr">';
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
		echo '</div>';//descr div 
		
		echo '</div>';//item div
		echo '</p>';
		echo '<br>';
		echo '<hr style="border:none;border-bottom:1px solid #ccc">';
	}	

  else/*auction item*/ 
  {
    echo '<br><div class="item">';
    $sql = "select sellerid,reserve_price,end_time,numofbidder,status from Auction_items where ItemID = '$itemid'";
    $query = mysqli_query($conn, $sql);
    $tmp = mysqli_fetch_array($query);
	  $nowtime = date('Y-m-d H:i:s');
    if($tmp['status'] != 0 || $tmp['end_time'] < $nowtime)/*not on auction*/
    {       
    }       
    else    
    {
      echo '<div class="picture">';       
		  echo '<img src="'.$row['picture'].'"  alt="No images available" >';
		  echo '</div>';//picture div
		  
		  echo '<div class="descr">';
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
		  echo '</div>';//descr div
		  
		  echo '</div>';//item div
		  echo '<br>';
		  echo '<hr style="border:none;border-bottom:1px solid #ccc">';
  	}
	}
}
echo '</div>';
mysqli_close($conn);
?>
</p>
</body>
</html> 
