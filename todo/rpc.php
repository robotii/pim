<?
include("../config.php");
switch($_REQUEST['action']) {

case 'completetoggle':

if($_REQUEST[id]) {
  $stmt = "update todo set complete = 1 - complete where id=$_REQUEST[id]";
  mysql_query($stmt,$dbh);
 }
break;

case 'delete':

if($_REQUEST[id]) {
  $stmt = "DELETE from todo where id=$_REQUEST[id]";
  mysql_query($stmt,$dbh);
}
break;

case "add": 

if($_REQUEST[todo]) {
  $stmt = "Insert Into todo (todo) Values(\"$_REQUEST[todo]\")";
  mysql_query($stmt,$dbh);
}

    case 'list': 
      break;

case "close":
  exit;

    case "save":
if($_REQUEST[id]>0) {
    $stmt = "Update todo set todo = '$_REQUEST[todo]', duedate = '$_REQUEST[duedate]' where id = $_REQUEST[id]";
    mysql_query($stmt,$dbh);
}
 break;
    case "edit":

  $stmt = "Select * from todo where id = $_REQUEST[id]";
  $sth  = mysql_query($stmt,$dbh);
  $row = mysql_fetch_array($sth);
?><h4>Edit Form</h4>
<label>Todo:</label><input type="text" id="edit_todo" value="<? echo $row[todo];?>">
<label>Due Date:</lable><input type="text" id="edit_duedate" value="<? echo $row[duedate];?>">
<a href="javascript:sndReq('todo','save&id=<? echo $_REQUEST[id];?>&todo='+$F('edit_todo')+'&duedate='+$F('edit_duedate'),'todolist');">Save</a>
<a href="javascript:sndReq('todo','close','editpane');">Close</a>

<?
      exit;
      break;

   }

?>
<h4>Todo List</h4>
<table>
<?
$sth = mysql_query("Select * from todo",$dbh);
while($row = mysql_fetch_array($sth, MYSQL_ASSOC)) {
?>
<tr>
<td><input type="checkbox" <? if($row["complete"] > 0) { echo "checked";} ?> onclick="javascript:sndReq('todo','completetoggle&id=<? echo $row[id];?>','todolist');"></td>
<td<? if($row[complete]>0) {
 echo " class=\"strikethrough\"";
}?>>
<a<? 
if((int)strtotime($row["duedate"]) < (int)time() && !$row["complete"]) { 
  echo " class=\"overdue\"";
}?> href="javascript:sndReq('todo','edit&id=<? echo $row[id] ?>','editpane');"><? echo $row["todo"]; ?></a>
</td> 
<td><a href="javascript:sndReq('todo','delete&id=<? echo $row[id] ?>','todolist');"><img src="images/delete.png"></a></td>
</tr>
<? } ?>
<tr><td>&nbsp;</td>
<td class="input"><input type="text" size="30" id="todo"></td><td><a href="javascript:sndReq('todo','add&todo=' + document.getElementById('todo').value,'todolist');">Add</a></td></tr>
</table>
<br>
