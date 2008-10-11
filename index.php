<? include("config.php")?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./wsp.css" />
<script type="text/javascript" src="prototype.js">
</script>
<script type="text/javascript" src="rico.js">
</script>
<script type="text/javascript">
function sndReq(module,action,location) {

    var myAjax = new Ajax.Updater(location, module + '/rpc.php', {method: 'get', parameters: 'action='+action});
    //http.open('get', module + '/rpc.php?action='+action);
    //http.onreadystatechange = handleResponse;
    //http.send(null);
}
</script>
</head>
<body>
<!--div id="masthead">Header</div>
<div id="topnav">TopNav</div-->
<div id="leftside">
    <div id="calendar"  class="leftsideSection">
       Please wait for the calendar to load...
    </div>
    <div id="todolist" class="leftsideSection">
       Please wait for the Todo List to load...
    </div>
</div>

<div id="contents" class="centreblock">
Content Pane
</div>
<div id="editpane">
</div>

<script type="text/javascript">
  // initialise the todo list
  sndReq('todo','list','todolist'); 
  // initialise the small calendar
  sndReq('calendar','list','calendar');
</script>
</body>
</html>