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


if($user) {
  $rh = mysql_query("SELECT * FROM users WHERE user='$user'",$dbh);
  $row = mysql_fetch_array($rh,MYSQL_ASSOC);
  if($password!=$row["password"] | $password=="") {
    die("Wrong Username or Password");
  }
}
?>

<?
if($newpassword2!="") {
  if($newpassword==$newpassword2) {
    mysql_query("UPDATE users SET password='$newpassword', stylesheet='$stylesheet' WHERE user='$user'",$dbh);
    $password = $newpassword2;
?>
<font face=arial>Your password has been successfully changed.<br>
Click <a href=todo.php>here</a> to continue
<?
  }
} 

if($stylesheet!="") {
    mysql_query("UPDATE users SET stylesheet='$stylesheet' WHERE user='$user'",$dbh);
  
?>
<font face=arial>Your Stylesheet has been successfully changed.<br>
Click <a href=todo.php>here</a> to continue
<?
} else {
?>

<font face=arial>
Please Enter the new password<br><br>
<form action=cp.php method=post>
<table width=40%>
<tr><td>New Password: <td><input type=password name=newpassword></td></tr>
<tr><td>Retype: <td><input type=password name=newpassword2></td></tr>
<tr><td>Stylesheet: <td><input type=text name=stylesheet value=<? echo $row["stylesheet"]; ?>></td></tr>
<tr><td><input type=submit value=Change></tr>
</table>
</form>
<?
}
?>