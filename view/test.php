<? include("../config.php");?>Date: <? echo $_REQUEST[day]."/".$_REQUEST[month]."/".$_REQUEST[year]; ?>

<h4>Tasks Due Today</h4>
<table>
<?
$sth = mysql_query("Select * from todo where duedate = '".$_REQUEST[year]."-".$_REQUEST[month]."-".$_REQUEST[day]."'",$dbh);
while($row = mysql_fetch_array($sth, MYSQL_ASSOC)) {
?>

<tr>
<td <? if($row[complete]>0) {echo "class=\"strikethrough\"";}?>>
<a href="javascript:sndReq('todo','edit&id=<? echo $row[id] ?>','editpane');"><? echo $row["todo"]; ?></a>
</td> 
</tr>
<? } ?>
</table>
<br>

