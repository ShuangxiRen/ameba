<?php
include "dbconnect2.php";
$nowtime = date('Y-m-d H:i:s');
/*$nowtime = "2019-03-13 10:00:00";*/
$sql = "select A.ItemID,A.SellerID, A.reserve_price, A.end_time, A.numofbidder, I.category, I.item_name,I.shippinginfo,I.shippingprice,I.location from Auction_items A, Items I where A.end_time <= '$nowtime' and A.status = 0 and A.ItemID = I.ItemID"; 
$endbiditem = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($endbiditem))
{
	$enditemid = $row['ItemID'];
	$reprice = $row['reserve_price'];
	$numofbidder = $row['numofbidder'];
	$bidsql = "select MAX(money) from Bidding where ItemID = '$enditemid'";
	$bidquery = mysqli_query($conn, $bidsql);
	$bidqueryrow = mysqli_fetch_array($bidquery);
	$maxmoney = $bidqueryrow[0];
	$biditemid = $row['ItemID'];
	$sellerid = $row['SellerID'];
	$endtime = $row['end_time'];
	$itemname1 = $row['item_name'];
	$itemname = addslashes($row['item_name']);
	$sellersql = "select username from Users where UserID = '$sellerid'";
	$sellerquery = mysqli_query($conn, $sellersql);
	$sellerqueryrow = mysqli_fetch_array($sellerquery);
	$sellername = $sellerqueryrow[0];
	if($maxmoney >= $reprice){/*bid success*/
		$category = $row['category'];
		$shippinginfotmp = $row['shippinginfo'];
		$shippinginfo = addslashes($shippinginfotmp);
		$shippingprice = $row['shippingprice'];
		$locationtmp = $row['location'];
		$location = addslashes($locationtmp);
		$buyeridsql = "select bidder from Bidding where ItemID = '$enditemid' and money = '$maxmoney'";  
		$buyeridquery = mysqli_query($conn, $buyeridsql);
		$buyeridqueryrow = mysqli_fetch_array($buyeridquery);
		$buyerid = $buyeridqueryrow[0];
		$buyernamesql = "select username from Users where UserID = '$buyerid'";
		$buyernamequery = mysqli_query($conn, $buyernamesql);
		$buyernamequeryrow = mysqli_fetch_array($buyernamequery);
		$buyername = $buyernamequeryrow[0];
		/**************************************change Auction_item's status**********************************/
		$thesql = "update Auction_items set status = 1 where ItemID = '$biditemid'";
		if(!mysqli_query($conn, $thesql))
		{
        	echo '<center>';
    		echo'<br/><br/><br/><br/><br/><br/>';
    		echo'<span style="font-size:20pt;color:red">Execute database failed!</span><br/><br/>';
        	echo '</center>';
			mysqli_close($conn);
    		exit;   
		}
		/**************************************tell seller bid success*****************************************/
		$query = mysqli_query($conn, "select MAX(MessageID) from Message");
		$queryrow = mysqli_fetch_array($query);
		$result = $queryrow[0];
		$newmessageid1 = $result + 1;
		$messagetoseller = "Congratulations! Your product&nbsp&nbsp\"".$itemname."\"&nbsp&nbspon auction was won by bidder&nbsp&nbsp".$buyername.".<br/>End time:&nbsp&nbsp".$endtime."&nbsp&nbsp&nbsp&nbspReserve price:&nbsp&nbsp$".$reprice."&nbsp&nbsp&nbsp&nbspNumber of bidder:&nbsp&nbsp".$numofbidder."<br/>Price given by&nbsp&nbsp".$buyername.":&nbsp&nbsp$".$maxmoney."&nbsp&nbsp&nbsp&nbspOrder status: waiting for payment";
		$sellermesql = "insert into Message(MessageID, sendtime, type, fromname, toname, title, message, status) values('$newmessageid1','$nowtime','1','Amabae','$sellername','Auction item sold','$messagetoseller','1')";
		if(!mysqli_query($conn, $sellermesql))
		{
        	echo '<center>';
    		echo'<br/><br/><br/><br/><br/><br/>';
    		echo'<span style="font-size:20pt;color:red">Execute database failed!</span><br/><br/>';
        	echo '</center>';
			mysqli_close($conn);
    		exit;   
		}
		/************************************insert an order with status 0(need to pay)*********************************/
		$orderquery = mysqli_query($conn, "select MAX(OrderID) from Orders");
		$orderqueryrow = mysqli_fetch_array($orderquery);
		$maxorderid = $orderqueryrow[0];
		$neworderid = $maxorderid + 1;
		$amount = $maxmoney;
		$insertordersql="insert into Orders(OrderID,ItemID,source,category,quantity,buyer,seller,supplier,order_time,bidornot,price,amount,shippingfee,status) values('$neworderid','$biditemid','1','$category','1','$buyerid','$sellerid','0','$nowtime','1','$reprice','$amount','$shippingprice','0')";
		if(!mysqli_query($conn, $insertordersql))
		{
        	echo '<center>';
    		echo'<br/><br/><br/><br/><br/><br/>';
    		echo'<span style="font-size:20pt;color:red">Execute database failed!</span><br/><br/>';
        	echo '</center>';
			mysqli_close($conn);
    		exit;   
		}

		/*********************************tell the bidder you won or not, please pay************************************/
		$query = mysqli_query($conn, "select MAX(MessageID) from Message");
		$queryrow2 = mysqli_fetch_array($query);
		$result = $queryrow2[0];
		$newmessageid2 = $result + 1;
		$messagetosucbidder = "Congratulations! You win the auction of product \"".$itemname."\"<br/>Seller:&nbsp&nbsp".$sellername."&nbsp&nbsp&nbsp&nbspYour bid price:&nbsp&nbsp$".$maxmoney."&nbsp&nbsp&nbsp&nbspOrder status:&nbsp&nbspwaiting for payment&nbsp&nbsp&nbsp&nbsp<br/>Shippingfee:&nbsp&nbsp$".$shippingprice."&nbsp&nbsp&nbsp&nbspPay ID:&nbsp&nbsp".$neworderid."&nbsp&nbsp&nbsp&nbsp<a href=\"myorder.php\" style=\"text-decoration:none\">Go to my order</a>";
		$biddersucmesql = "insert into Message(MessageID, sendtime, type, fromname, toname, title, message, status) values('$newmessageid2','$nowtime','1','Amabae','$buyername','Win an auction','$messagetosucbidder','1')";
		if(!mysqli_query($conn, $biddersucmesql))
		{
        	echo '<center>';
    		echo'<br/><br/><br/><br/><br/><br/>';
    		echo'<span style="font-size:20pt;color:red">Execute database failed!</span><br/><br/>';
        	echo '</center>';
			mysqli_close($conn);
    		exit;   
		}

	/*	echo $messagetoseller;
		echo '<br/>';
		echo '<br/>';
		echo $messagetosucbidder;
		echo '<br/>';
		echo '<br/>';
		echo $sellermesql;
		echo '<br/>';
		echo '<br/>';
		echo $biddersucmesql;
		echo '<br/>';
		echo '<br/>';
		echo $insertordersql;
		echo '<br/>';*/
	}
	else{/*no money more that reserve price, bid failed*/
		/************************************change Auction_item's status***********************************************/
		$thesql = "update Auction_items set status = 2 where ItemID = '$biditemid'";
        if(!mysqli_query($conn, $thesql))
        {       
            echo '<center>';
            echo'<br/><br/><br/><br/><br/><br/>';
            echo'<span style="font-size:20pt;color:red">Execute database failed!</span><br/><br/>';
            echo '</center>';
			mysqli_close($conn);
            exit;   
        }  
		/************************************Send a message to seller, bid failed**************************************/
		$query = mysqli_query($conn, "select MAX(MessageID) from Message");
		$queryrow3 = mysqli_fetch_array($query);
		$result = $queryrow3[0];
		$newmessageid1 = $result + 1;
		$messagetoseller = "Sorry, your product&nbsp&nbsp\"".$itemname."\"&nbsp&nbspon auction didn\'t sell.<br/>End time:&nbsp&nbsp".$endtime."&nbsp&nbsp&nbsp&nbspReserve price:&nbsp&nbsp$".$reprice."<br/>Number of bidder:&nbsp&nbsp".$numofbidder."&nbsp&nbsp&nbsp&nbspHighest price given by bidders:&nbsp&nbsp$".$maxmoney;
		$sellermesql = "insert into Message(MessageID, sendtime, type, fromname, toname, title, message, status) values('$newmessageid1','$nowtime','1','Amabae','$sellername','Item did not sell','$messagetoseller','1')";
		if(!mysqli_query($conn, $sellermesql))
		{
        	echo '<center>';
    		echo'<br/><br/><br/><br/><br/><br/>';
    		echo'<span style="font-size:20pt;color:red">Execute database failed!</span><br/><br/>';
        	echo '</center>';
			mysqli_close($conn);
    		exit;   
		}
		/***************************************tell every bidder you bid failed*****************************************/
	}
}
?>
