<?php
$conn=mysqli_connect("127.0.0.1","root","thinker", "newamabae");
if (!$conn){
  echo '<center>';
  echo "Cannot connect database!";
  echo '</center>';
  exit();
}
?>
