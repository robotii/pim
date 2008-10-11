<? include("config.php")?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./wsp.css" />
<script type="text/javascript">

function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}

var http = createRequestObject();

function sndReq(action) {
    http.open('get', 'rpc.php?action='+action);
    http.onreadystatechange = handleResponse;
    http.send(null);
}

function sndCalendar(action) {
    http.open('get', 'tiny_calendar.php?action='+action);
    http.onreadystatechange = handleResponse;
    http.send(null);
}


function handleResponse() {
    if(http.readyState == 4){
        var response = http.responseText;
        var update = new Array();

        if(response.indexOf('|' != -1)) {
            update = response.split('|');
            document.getElementById(update[0]).innerHTML = update[1];
        }
    }
}

</script>
</head>
<body>

<div id="masthead">
Header
</div>
<div id="leftcol">
leftcol
</div>
<div class="middle">
Content
</div>
<div id="rightcol">
<div id="calendar">
Calendar
</div>
<div id="todolist">
</div>
</div>
<div id="menu">
</div>
<script type="text/javascript">
  sndReq('list');
</script>
</body>
</html>