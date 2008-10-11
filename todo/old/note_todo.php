<title>
To Do List - Notes
</title>

<h1>
View Notes
</h1>
<font face=arial>Please note this is alpha level code, so expect there to be bugs in it<br>
<hr><br>
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



if($nid) {
  if($action=="delete") {
    mysql_query("DELETE FROM notes WHERE id=$nid",$dbh);
  }
  if($action=update) {
    mysql_query("UPDATE notes SET note='$note' WHERE id=$nid",$dbh);
  }
} 
else
{
  if($note) {
    mysql_query("INSERT INTO notes (itemid,note) VALUES($id,'$note')",$dbh);
  }
}
  
if($id) {
?>
<table width=60% align=center border=1>
<?
  $stmt = "SELECT * FROM notes WHERE itemid=$id";
  $rh = mysql_query($stmt,$dbh);
  if(mysql_num_rows($rh)>0) {
    while($row = mysql_fetch_array($rh,MYSQL_ASSOC)) {
?>
<tr><td class=item align=center><font face=arial>
<?
   
$s = eregi_replace("<link[[:space:]]\'([^']+)\'[[:space:]]\'([^']+)\'>","<a href=\"/dynamic/main.php?page=\\1\">\\2</a>",$row["note"]);

$row["note"] = eregi_replace("<link[[:space:]]\'([^']+)\'>([^\<]+)</link>","<a href=\"/dynamic/main.php?page=\\1\">\\2</a>",$s);

$row["note"] = eregi_replace("<link[[:space:]]\'([^']+)\'>","<a href=\"/dynamic/main.php?page=\\1\">\\1</a>",$row["note"]);



   echo $row[note];
?>
</td><td class=links width=12%><a href=note_todo.php?nid=<? echo "$row[id]&id=$id&action=delete"; ?>>Delete</a></td></tr>
<?
    }
  }
?>
<tr><td align=center><form action=note_todo.php method=post>
<input type=text name=note size=50>
<input type=hidden name=id value=<? echo $id;?>>
<input type=submit name=Add value=Add>
</form></td><td><a href=note_todo.php?id=<? echo $id; ?>>Refresh</a></tr>
</table>
<?
}
?>
<br>
<hr>

<a href=todo.php>Main page</a> <a href=show_todo.php?id=<? echo $id; ?>>Previous Page</a>
