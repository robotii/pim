<html>
<head>
  <script type="text/javascript" src="/prototype.js"></script>
  <script type="text/javascript" src="/rico.js"></script>
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

function handleResponse() {
    if(http.readyState == 4){
        var response = http.responseText;
        var update = new Array();

        if(response.indexOf('|' != -1)) {
            update = response.split('|');
            document.getElementById(update[0]).value = update[1];
        }
    }
}

</script>

<style type="text/css">
div.box  
{
    font-family: Arial;
    font-size: 14px;
    width: 100px;
    height: 40px;
    text-align: center;
    border-bottom-width: 1px;
    border-bottom-style: solid;
    border-bottom-color: rgb(107, 107, 107);
    border-right-width: 1px;
    border-right-style: solid;
    border-right-color: rgb(107, 107, 107);
}
div.panel {
    width: 200px;
    height: 80px;
    padding-top: 2px;
    padding-right-value: 2px;
    padding-bottom: 2px;
    padding-left-value: 2px;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-top-style: solid;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: solid;
    border-top-color: rgb(91, 91, 91);
    border-right-color: rgb(91, 91, 91);
    border-bottom-color: rgb(91, 91, 91);
    border-left-color: rgb(91, 91, 91);
}

div.title
{
    font-family: Arial;
    font-size: 10px;
    background-color: rgb(121, 121, 121);
    color: rgb(255, 255, 255);
    width: 200px;
    margin-top: 1px;
    margin-right-value: 1px;
    margin-bottom: 1px;
    margin-left-value: 1px;
    margin-left-ltr-source: physical;
    margin-left-rtl-source: physical;
    margin-right-ltr-source: physical;
    margin-right-rtl-source: physical;
}
</style>
</head>
<body>
 <div id="myAccordion">
    <div id="myFirstTab">
       <div>First Tab</div>
       <div id="fo">Content of first tab</div>
    </div>
    <div id="myFirstTab">
       <div>First Tab</div>
       <div>Content of first tab</div>
    </div>
    <div id="myFirstTab">
       <div>First Tab</div>
       <div>Content of first tab</div>
    </div>
  </div>

<script type="text/javascript">
new Rico.Accordion( 'myAccordion');
</script>

   <div class="box" style="background:#f7a673" id="dragme">
      Drag Me
   </div>
<table><tr><td>
   <div style="margin-bottom:8px;">
      <div id="droponme" class="panel" style="display:inline;background:#ffd773">
         <div class="title">Drop On Me</div>
      </div>

     </td><td>
									
      <div id="droponme2" class="panel" style="display:inline;background:#c6c3de">
         <div class="title">Drop On Me 2</div>
      </div>
   </div>
</td></tr></table>
   <script>
      dndMgr.registerDraggable( new Rico.Draggable('test-rico-dnd','dragme') );
      dndMgr.registerDropZone( new Rico.Dropzone('droponme') );
      dndMgr.registerDropZone( new Rico.Dropzone('droponme2') );



   </script>
<input type="text" id="contents">
  <a href="javascript:sndReq('list')">[foo]</a>
</body>
</html>