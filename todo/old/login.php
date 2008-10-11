<?php
//error_reporting(E_ERROR|E_PARSE);
session_start();
session_unregister("user");
session_unregister("password");

?>
<style> @import url(/dynamic/serveraw.php?page=default.css); </style><body onLoad="show_clock()"><div align=right><script language="javascript" src="/dynamic/serveraw.php?page=clock.js"></script></div>
<font face=arial>
Please Login Below<br>
<form method=post action=todo.php>
<table width= 40%>
<tr></tr>
<tr><td>Username: </td><td><input type=text name=user size=20></td></tr>
<tr><td>Password: </td><td><input type=password name=password size=20></td></tr>
<tr><td><input type=submit name=s value=Login></tr>
<table>
</form>