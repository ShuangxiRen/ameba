<?php
  session_start();
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<title>Amabae sale item upload</title>
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
<span style="font-size:28px;">Upload products for sale</span>
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
?>
</br>
<div style="margin-left:10%">
<form action="saleitemupload.php" method="post">
<b>What you're selling</b><span style="color:red">*</span><br/>
<input type="text" style="width:600px;" name="itname" /><br/><br/>
<b>Category</b><span style="color:red">*</span><br/>
<select name="category">
<option value="0" selected="selected">ALL</option>
<option value="1"  style = "white-space: nowrap">&nbsp&nbspElectronics</option>
<option value="2">&nbsp&nbspCell phones</option>
<option value="3">&nbsp&nbspSmartpnone</option>
<option value="4">&nbsp&nbspAccessories</option>
<option value="5">&nbsp&nbspComputer</option>
<option value="6">&nbsp&nbspLaptop</option>
<option value="7">&nbsp&nbspTablets</option>
<option value="8">&nbsp&nbspDesktop</option>
<option value="9">&nbsp&nbspParts</option>
<option value="10">&nbsp&nbspClothing&Shoes</option>
<option value="11">&nbsp&nbspWomen</option>
<option value="12">&nbsp&nbspJeans</option>
<option value="13">&nbsp&nbspCoats</option>
<option value="14">&nbsp&nbspShoes</option>
<option value="15">&nbsp&nbspMen</option>
<option value="16">&nbsp&nbspJeans</option>
<option value="17">&nbsp&nbspT-shirts</option>
<option value="18">&nbsp&nbspShoes</option>
<option value="19">&nbsp&nbspAppliances</option>
<option value="20">&nbsp&nbspKitchen</option>
<option value="21">&nbsp&nbspMicrowave</option>
<option value="22">&nbsp&nbspFrigerator</option>
<option value="23">&nbsp&nbspBurner</option>
<option value="24">&nbsp&nbspLivingroom</option>
<option value="25">&nbsp&nbspTV</option>
<option value="26">&nbsp&nbspAirconditioner</option>
<option value="27">&nbsp&nbspBooks</option>
<option value="28">&nbsp&nbspText books</option>
<option value="29">&nbsp&nbspEducation</option>
<option value="30">&nbsp&nbspComputer Science</option>
<option value="31">&nbsp&nbspSocial Science</option>
<option value="32">&nbsp&nbspMagazines</option>
<option value="33">&nbsp&nbspFashion&Style</option>
<option value="34">&nbsp&nbspCooking</option>
<option value="35">&nbsp&nbspChildren's Books</option>
<option value="36">&nbsp&nbspGames</option>
<option value="37">&nbsp&nbspAnimals</option>
<option value="38">&nbsp&nbspEarly Learning</option>
</select><br/><br/>
<b>Description</b><span style="color:red">*</span><br/>
<textarea name="description" cols ="83" rows = "5"></textarea><br/><br/>
<b>Location</b><span style="color:red">*</span><br/>
<input type="text" style="width:600px;" name="location" /><br/><br/>
<b>Quantity</b><span style="color:red">*</span><br/>
<input type="text" style="width:300px;" name="quantity" /><br/><br/>
<b>Unit Price</b><span style="color:red">*</span><br/>
<input type="text" style="width:300px;" name="price" />$<br/><br/>
<b>Shipping information</b><span style="color:red">*</span><br/>
<input type="text" style="width:300px;" name="shippinginfo" /><i>(for example: UPS, three days)</i><br/><br/>
<b>Shipping price</b><span style="color:red">*</span><br/>
<input type="text" style="width:300px;" name="shippingprice" />$<br/></br>
</br>
<input type="submit" style="margin-left:10%;width:200px;" value="Upload my product" />
<br/>
<br/>
</form>
</div>
</center>
</div>
</body>
</html>
