'use strict';

class Phoneline {
    constructor(host, port) {
        this.host = host;
        this.port = port;
        this.socket = null;
    }

    connect() {
    	var host = "ws://" + this.host + ":" + this.port + "/member/list/";
    	try {
    		this.socket = new WebSocket(host);

    		// log('WebSocket - status '+this.connection.readyState);

    		this.socket.onopen = function(msg) {
                log("Welcome - status "+this.readyState);
    		};
    		this.socket.onmessage = function(msg) {
                log("Received: "+msg.data);
            };
    		this.socket.onclose   = function(msg) {
                log("Disconnected - status "+this.readyState);
            };
    	} catch(ex){
    		log(ex);
    	}
    }
    send(obj) {
    	try {
    		this.socket.send(JSON.stringify(obj));
    	} catch(ex) {
    		log(ex);
    	}
    }
    quit(){
    	if (this.socket != null) {
    		log("Goodbye!");
    		this.socket.close();
    		this.socket = null;
    	}
    }
    reconnect() {
    	quit();
    	init();
    }
    log(msg) {
        console.log(msg)
    }
}
