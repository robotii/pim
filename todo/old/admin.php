<?
header ("Cache-Control: no-cache, must-revalidate");  
?>
<title>
To Do List Admin
</title>

<h1>
To Do List Admin
</h1>
<font face=arial>Please note this is alpha level code, so expect there to be bugs in it<br>
<hr>
<?php

error_reporting(E_ERROR|E_PARSE);
session_register("user");
session_register("password");
$horribly = "You must be an admin user to view this page.<br>Click <a href=todo.php>here to continue</a>";

$dbh = mysql_connect("localhost","root","iamgod");
mysql_select_db("timetable");
if($user=="admin") {
  $rh = mysql_query("SELECT * FROM users WHERE user='admin'",$dbh);
  $row = mysql_fetch_array($rh,MYSQL_ASSOC);
  if($password!=$row["password"] | $password=="") {
    die("Wrong Username or Password");
  }
}
else { die($horribly); }

$rh = mysql_query("SELECT * FROM users WHERE user='$user'",$dbh);
$row = mysql_fetch_array($rh,MYSQL_ASSOC);
echo "<style> @import url(/dynamic/serveraw.php?page=$row[stylesheet]); </style>";


if($username!="") {
  if($id) {
    $stmt = "UPDATE users SET user = \"$username\", password='$password1' WHERE id=$id";
    mysql_query($stmt,$dbh);
    $stmt = "UPDATE todo SET user = \"$username\" WHERE user=\"$oldname\" ";
  }
  else {
    $stmt = "INSERT INTO users (user, password) VALUES('$username', '$password1')";
  }
  echo $stmt;
  mysql_query($stmt,$dbh);
} 

if($action=="delete" && $id) {
  echo "DELETE FROM users WHERE id=$id";
  mysql_query("DELETE FROM users WHERE id=$id",$dbh);
}

if($action=="login") {
  $stmt = "SELECT * FROM users WHERE id=$id";
  $rh = mysql_query($stmt,$dbh);
  $row = mysql_fetch_array($rh,MYSQL_ASSOC);

  $user = $row["user"];
  $password=$row["password"];
  die(" Click <a href=todo.php>here</a> to continue");
}

$stmt = "SELECT * FROM users";
echo "<br>";

if($orderby) {
  $stmt .= " ORDER BY " . $orderby;
}

$sth = mysql_query($stmt,$dbh);
?>

<table width=50% border=1>
<tr>
<td colspan=3 width=40%><font face=arial><a href=admin.php?orderby=user><b>Name</b></a></td>
<td><font face=arial><b>Password</b></td>
</tr>

<?
while($row = mysql_fetch_array($sth, MYSQL_ASSOC)) {

?>


<tr>
<form action="admin.php" method=post><font face=arial>
  <td width=30%><font face=arial>
    <input type=text size=20 name=username value="<? echo $row["user"]; ?>">
    <input type=hidden name=oldname value="<? echo $row["user"]; ?>">
  </td>
  <td>
    <a href=admin.php?id=<? echo $row[id];?>&action=login>Login</a>
  </td>
  <td>
    <a href=admin.php?id=<? echo $row[id];?>&action=delete>Delete</a>
  </td> 
  <td align=center><font face=arial>
    <input type=text size=10 name=password1 value=<? echo $row["password"] ; ?>>
<input type=hidden name=id value=<? echo $row["id"]; ?>>
<input type=submit value=Update>
</td></form></tr>
<?
}
?>

</table>
<br>
<form action="admin.php" method=post><font face=arial>
User: <input type=text size=20 name=username>
Password: <input type=text size=10 name=password1>
<input type=submit value=Add>
</form>
<hr>
<?

if($user!="") { ?>
<a href=cp.php>Change Password</a>
<?
}
?>
<a href=login.php>Logout</a>
<a href=admin.php?showall=true>Show all</a>