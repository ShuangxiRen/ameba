<?php
$con=mysql_connect("127.0.0.1","root","thinker");
if (!$con){
  echo '<center>';
  echo "Cannot connect database!";
  echo '</center>';
  exit();
}
mysql_select_db("newamabae",$con);
?>
