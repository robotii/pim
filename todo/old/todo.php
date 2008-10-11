<?
header ("Cache-Control: no-cache, must-revalidate");  
?>
<title>
To Do List
</title>
<body onLoad="show_clock()"><div align=right><script language="javascript" src="/dynamic/serveraw.php?page=clock.js"></script></div>
<h1>
To Do List
</h1>


<?php

error_reporting(E_ERROR|E_PARSE);
session_register("user");
session_register("password");
session_register("showall2");
if($showall!="") {
  $showall2 = $showall;
} else {
  $showall = $showall2;
}

if($user!="") { ?>
<p>Logged in as <? echo $user;?></p>

<a href=cp.php>Change Password</a>
<?
}
?>
<a href=login.php>Logout</a>
<?
if($showall=="true") {
  echo "<a href=todo.php?showall=false>Hide</a>";
} else { 
  echo "<a href=todo.php?showall=true>Show all</a>";
} 
?>
<hr>
<?
$dbh = mysql_connect("localhost","root","iamgod");
mysql_select_db("timetable");
if($user) {
  $rh = mysql_query("SELECT * FROM users WHERE user='$user'",$dbh);
  $row = mysql_fetch_array($rh,MYSQL_ASSOC);
  if($password!=$row["password"] | $password=="") {
    die("Wrong Username or Password");
  }
  echo "<style> @import url(/dynamic/serveraw.php?page=$row[stylesheet]); </style>";
} else {
  echo "<style> @import url(/dynamic/serveraw.php?page=default.css); </style>";
}

if($action == "delete") {
  if($id) {
    $stmt = "DELETE from todo where id=$id AND user='$user'";
    mysql_query($stmt,$dbh);
    echo "<font face=arial style='color: red;'>Item deleted<br>";
  }
}

if($item) {
  if($id) {
    $stmt = "UPDATE todo SET note = \"$item\",done=$done, dd='$dd', mm='$mm', yyyy='$yyyy', priority=$priority WHERE id=$id";
  }
  else {
    $stmt = "INSERT INTO todo (note,done,user) VALUES(\"$item\",0, '$user')";
  }
  if($pre!=0) {
    mysql_query("INSERT INTO pre (item,pre) VALUES($id,$pre)",$dbh);
  }
  mysql_query($stmt,$dbh);
} 


$stmt = "SELECT * FROM todo WHERE user='$user'";
echo "<br>";

if($showall!="true") {
  $stmt .= " AND top='1'";
}

if($orderby) {
  $stmt .= " ORDER BY " . $orderby;
}

$sth = mysql_query($stmt,$dbh);
?>

<table border=1>
<tr class=header>
<td width=73% colspan=2><font face=arial><a href=todo.php?orderby=note><b>Item</b></a></td>
<td><font face=arial><b><a href=todo.php?orderby=done>Completed</a></b></td>
<td><font face=arial><b><a href=todo.php?orderby=yyyy,%20mm,%20dd>Due Date</a></b></td>
<td><font face=arial><b><a href=todo.php?orderby=priority>Priority</a></b></td>
<td><font face=arial><b>Prerequisite</b></td>
<td><font face=arial><b>Notes</b></td></tr>

<?
while($row = mysql_fetch_array($sth, MYSQL_ASSOC)) {

$s = eregi_replace("<link[[:space:]]\'([^']+)\'[[:space:]]\'([^']+)\'>","<a href=\"/dynamic/main.php?page=\\1\">\\2</a>",$row["note"]);

$row["note"] = eregi_replace("<link[[:space:]]\'([^']+)\'>([^\<]+)</link>","<a href=\"/dynamic/main.php?page=\\1\">\\2</a>",$s);

$row["note"] = eregi_replace("<link[[:space:]]\'([^']+)\'>","<a href=\"/dynamic/main.php?page=\\1\">\\1</a>",$row["note"]);


?>


<tr class=details><td class=item width=60%><font face=arial>

  <? echo $row["note"]; ?>
  </td> <td class=links width=12%><font face=arial><a href=show_todo.php?id=<? echo $row["id"]; ?>
>show</a>|<font face=arial><a href=edit_todo.php?id=<? echo $row["id"]; ?>
>edit</a>|<a href=todo.php?action=delete&id=<? echo $row["id"]; ?>
>delete</a></td><td class=percent align=center><font face=arial>
  <img align=left height=5px margin=0px width=<?= $row[done];?>% src="red.gif">
</td>
<td class=date><font face=arial>
<? echo $row["dd"] . "/" . $row["mm"] . "/" . $row["yyyy"]; ?>
</td><td class=priority> <font face=arial><? echo $row["priority"]; ?> </td>
<td class=links><font face=arial>
<? 

$stmt = "SELECT * from pre where item=$row[id]";
$sth2 = mysql_query($stmt,$dbh);
$ft="";
while($row2 = mysql_fetch_array($sth2, MYSQL_ASSOC)) {
  $ft="ft";
}
if($ft=="ft") { ?>

<a href=<?
echo "show_req.php?id=$row[id]>Requires</a>";
}
else {
echo "none";
}
?>

</td>
<td class=links><a href=note_todo.php?id=<? echo $row[id];?>>View</a></td>
</tr>

<? } ?>

</table>
<br>
<form action="todo.php" method=post><font face=arial>
Item: <input type=text size=50 name=item>
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
<?
if($showall=="true") {
  echo "<a href=todo.php?showall=false>Hide</a>";
} else { 
  echo "<a href=todo.php?showall=true>Show all</a>";
} 
?>