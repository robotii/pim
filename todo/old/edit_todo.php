<SCRIPT type="text/javascript" language="JavaScript1.2">
function ShowPopupWindow(fileName) 
{
    myFloater = window.open('','myWindow','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=300,height=300')
    myFloater.location.href = fileName;
}

// LAUNCH POP-UP INFORMATION WINDOWS
function launchWindow(type)
{
	var url="";
	if (type=="information1") url="info/information1.html";
	if (type=="information2") url="info/information2.html";
	if (type=="information3") url="info/information3.html";
	if (type=="information4") url="info/information4.html";
	if (type=="information5") url="info/information5.html";
	if (type=="information6") url="info/information6.html";

	window.open(url, "information",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=300,height=350');
}
</script>

<?php

include("todo.inc.php");

//if(action=="Update") {
//
//  $dbh = mysql_connect("localhost","root","iamgod");
//  mysql_select_db("timetable");
//  if($item!="") {
//    if($id!="") {
//      $stmt = "UPDATE todo SET note = \"$item\",done=$done, dd='$dd', mm='$mm', yyyy='$yyyy', priority=$priority, pre=$pre //WHERE id=$id";
//    }
//    else {
//      $stmt = "INSERT INTO todo (note,done,dd,mm,yyyy,priority,pre) VALUES(\"$item\",$done,$dd,$mm, $yyyy,$priority,$pre)";
//      echo $stmt;
//      mysql_query($stmt,$dbh);
//      $sth = mysql_query("SELECT id from todo WHERE note=\"$item\", one=$done, dd='$dd', mm='$mm', yyyy='$yyyy'",$dbh);
//      $row = mysql_fetch_array($sth, MYSQL_ASSOC);
//      $id=$row[id];
//    }
//    if($pre!=0) {
//      mysql_query("INSERT INTO pre (item,pre) VALUES($id,$pre)",$dbh);
//    }
//    mysql_query($stmt,$dbh);
//  } 
//}
?>

<h1></h1>

<?
$dbh = mysql_connect("localhost","root","");
mysql_select_db("todo");

error_reporting(E_ERROR|E_PARSE);
session_register("user");
session_register("password");
session_register("showall2");

$rh = mysql_query("SELECT * FROM users WHERE user='$user'",$dbh);
$row = mysql_fetch_array($rh,MYSQL_ASSOC);
echo "<style> @import url(/dynamic/serveraw.php?page=$row[stylesheet]); </style>";


if($action=="remove") {
  if($id) {
    $sth = mysql_query("SELECT item FROM pre WHERE id=$id",$dbh);
    $row = mysql_fetch_array($sth,MYSQL_ASSOC);
    $return = $row[item];
    $stmt = "DELETE FROM pre WHERE id=$id";
    mysql_query($stmt,$dbh);
    $id=$return;
    echo "<font face=arial>item deleted<br>";
  }
}

if($top!=1) {
  $top=0;
}

if($item) {
  if($id) {
    $stmt = "UPDATE todo SET note = \"$item\",done=$done, dd='$dd', mm='$mm', yyyy='$yyyy', priority=$priority, top=$top WHERE id=$id";
  }
  else {
    $stmt = "INSERT INTO todo (note,done,user,top) VALUES(\"$item\",0, '$user',1)";
  }
  if($pre!=0) {
    mysql_query("INSERT INTO pre (item,pre) VALUES($id,$pre)",$dbh);
  }
  mysql_query($stmt,$dbh);
} 


if($id) {
  $stmt = "SELECT * from todo where id=$id";
  $sth = mysql_query($stmt,$dbh);
  $row = mysql_fetch_array($sth, MYSQL_ASSOC);
  $check=$row["top"];
}
?>


<font face=arial size=12><table width=64%>
<form action="edit_todo.php" method=post>
<tr height=20%><td></td><td align=center><font face=arial><b>Edit Item Details</b><br></td></tr>
<tr><td width=25%></td><td>
Item: </td><td><input type=text size=50 name=item value="<?
$i = htmlspecialchars($row["note"]);
 echo $i; 
?>" > <!--a href=javascript:launchWindow('information1')--><img src=info_i.gif><!--/a--></td></tr><tr><td width=25%></td><td>
Completed (%): </td><td><input type=text size=2 name=done value=<? 
echo $row["done"];?> > <img src=info_i.gif></td></tr><tr><td width=25%></td><td>
Due Date: </td><td><input type=text name=dd size=2 value=<?
echo $row["dd"]; ?> >/
<input type=text name=mm size=2 value=<?
echo $row["mm"]; ?> >/
<input type=text name=yyyy size=5 value=<?
echo $row["yyyy"]; ?> > <img src=info_i.gif></td></tr>
<tr><td></td><td>Priority: </td><td><input type=text size=2 name=priority value=<? 
echo $row["priority"]; ?> > <img src=info_i.gif></td></tr>

<?
if($id) {
  $stmt = "SELECT * from pre where item=$id";
  $sth = mysql_query($stmt,$dbh);
  $ft="";
  while($row = mysql_fetch_array($sth, MYSQL_ASSOC)) {
    echo "<tr><td></td><td>";
    if($ft!="ft") {
      echo "Requires";
      $ft="ft";
    }
    echo "</td><td>";
    $stmt = "SELECT * from todo where id=$row[pre]";
    $sth1 = mysql_query($stmt,$dbh);
    $row1 = mysql_fetch_array($sth1, MYSQL_ASSOC);

$s = eregi_replace("<link[[:space:]]\'([^']+)\'[[:space:]]\'([^']+)\'>","<a href=\"/dynamic/main.php?page=\\1\">\\2</a>",$row1["note"]);

$row1["note"] = eregi_replace("<link[[:space:]]\'([^']+)\'>([^\<]+)</link>","<a href=\"/dynamic/main.php?page=\\1\">\\2</a>",$s);

$row1["note"] = eregi_replace("<link[[:space:]]\'([^']+)\'>","<a href=\"/dynamic/main.php?page=\\1\">\\1</a>",$row1["note"]);


    echo "<span class=required>$row1[note]</span></td><td><a href=edit_todo.php?id=$row[id]&action=remove>Remove</a></td></tr>";
  }
}
?>

<tr><td></td><td>Prerequisite: </td><td><select name=pre>
<option value=0>none</option>
<?
if($id) {
  if($row[pre]!=0) {
    $stmt = "SELECT * from todo where id=$row[pre]";
    $sth = mysql_query($stmt,$dbh);
    $row = mysql_fetch_array($sth, MYSQL_ASSOC);
    echo "<option value=$row[id] selected>$row[note]</option>";
  }
}
$stmt = "SELECT * from todo WHERE user='$user'";
$sth = mysql_query($stmt,$dbh);
while($row = mysql_fetch_array($sth, MYSQL_ASSOC)) {
  echo "<option value=$row[id]>$row[note]</option>";
}

?><td><input type=submit value=Add>
<tr><td></td><td>Show:</td><td><input type=checkbox value=1 name=top <? if($check>0) echo "checked=1";?>></td>
</tr><tr><td></td><td colspan=2>
<hr><input type=hidden value=<? echo $id; ?> name=id>
<input type=submit name=action value=Update> <a href="todo.php">Main page</a></td></tr>
</form>
</table>
