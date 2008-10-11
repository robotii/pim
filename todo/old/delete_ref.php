<?php

$dbh = mysql_connect("localhost","root","iamgod");
mysql_select_db("timetable");

error_reporting(E_ERROR|E_PARSE);
session_register("user");
session_register("password");
session_register("showall2");

$rh = mysql_query("SELECT * FROM users WHERE user='$user'",$dbh);
$row = mysql_fetch_array($rh,MYSQL_ASSOC);
echo "<style> @import url(/dynamic/serveraw.php?page=$row[stylesheet]); </style>";


if($id) {
  $sth = mysql_query("SELECT item FROM pre WHERE id=$id",$dbh);
  $row = mysql_fetch_array($sth,MYSQL_ASSOC);
  $return = $row[item];
  $stmt = "DELETE FROM pre WHERE id=$id";
  mysql_query($stmt,$dbh);
  echo "<font face=arial>item deleted<br>";
}
?>

return to <a href=edit_todo.php?id=<? echo $return;?>>previous page</a>
<hr>