<?php


?>
<font face=arial>
These are all of the tasks that the selected task depends on directly.<br>
Please note this is alpha level code so the results may not be dependable
<hr>
<br>


<?
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
  $stmt = "SELECT * from pre where item=$id";
  $xh = mysql_query($stmt,$dbh);
  while($xat = mysql_fetch_array($xh, MYSQL_ASSOC)) {
    $stmt = "SELECT * from todo where id=$xat[pre]";
    $sth1 = mysql_query($stmt,$dbh);
    $row = mysql_fetch_array($sth1, MYSQL_ASSOC);

$s = eregi_replace("<link[[:space:]]\'([^']+)\'[[:space:]]\'([^']+)\'>","<a href=\"/dynamic/main.php?page=\\1\">\\2</a>",$row["note"]);

$row["note"] = eregi_replace("<link[[:space:]]\'([^']+)\'>([^\<]+)</link>","<a href=\"/dynamic/main.php?page=\\1\">\\2</a>",$s);

$row["note"] = eregi_replace("<link[[:space:]]\'([^']+)\'>","<a href=\"/dynamic/main.php?page=\\1\">\\1</a>",$row["note"]);




?>

<font face=arial size=12><table width=64%>
<tr height=20%><td></td><td align=center><font face=arial><b>Item Details</b><br></td></tr>
<tr><td width=25%></td><td>
Item: </td><td>
<?
//$i = htmlspecialchars($row["note"]);
$i = $row["note"];
 echo $i; 
?>
</td></tr><tr><td width=25%></td><td>
Completed (%): </td><td>
<? 
echo $row["done"];?> 
</td></tr><tr><td width=25%></td><td>
Due Date: </td><td>
<?
echo $row["dd"]; ?>/<?
echo $row["mm"]; ?>/<?
echo $row["yyyy"]; ?></td></tr>
<tr><td></td><td>Priority: </td><td>
<? 
echo $row["priority"]; ?></td></tr>
<tr><td></td><td>Prerequisite: </td><td>
<?

$stmt = "SELECT * from pre where item=$row[id]";
$sth5 = mysql_query($stmt,$dbh);
$ft="";
while($row1 = mysql_fetch_array($sth5, MYSQL_ASSOC)) {
  echo "<tr><td></td><td>";
  if($ft!="ft") {
    echo "Requires";
    $ft="ft";
  }
  echo "</td><td>";
  $stmt = "SELECT * from todo where id=$row1[pre]";
  $sth6 = mysql_query($stmt,$dbh);
  $row3 = mysql_fetch_array($sth6, MYSQL_ASSOC);
  echo "<a href=show_todo.php?id=$row3[id]>$row3[note]</a></td></tr>";
}

?>

<tr><td></td><td colspan=2>
<hr>
<a href=note_todo.php?id=<? echo $row[id]; ?> >Notes</a>
<a href=edit_todo.php?id=<? echo $row[id]; ?> >Edit</a>
<a href=todo.php>Back to main page</a></td></tr>
</table>
<? 
  }
}
?>