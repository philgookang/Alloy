<html><head><title>WebSocket</title>
<style type="text/css">
html,body {
	font:normal 0.9em arial,helvetica;
}
#log {
	width:600px;
	height:300px;
	border:1px solid #7F9DB9;
	overflow:auto;
}
#msg {
	width:400px;
}
</style>
<script type="text/javascript" src="/public/socket_example/Phoneline.js"></script>
<script type="text/javascript">
    function $(id) { return document.getElementById(id); }

    var phoneline = new Phoneline("13.124.88.194", "1009");
    phoneline.connect();

    function onkey(event) {
        if(event.keyCode==13){
            send();
        }
    }
    var send = function() {
        phoneline.send({ "msg" : $("msg").value });
    }
    function log(msg){
        $("log").innerHTML+="<br>"+msg;
    }
</script>
</head>
    <body>
    <h3>WebSocket v2.00</h3>
        <div id="log"></div>
        <input id="msg" type="textbox" onkeypress="onkey(event)"/>
        <button onclick="send()">Send</button>
        <button onclick="phoneline.quit()">Quit</button>
        <button onclick="phoneline.reconnect()">Reconnect</button>
    </body>
</html>
