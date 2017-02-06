var express = require('express');
var app     = express();
var path    = require("path");
var http    = require('http').Server(app);
var io      = require('socket.io')(http);
var router  = express.Router();

var routes  = require("./routes.js")(router);

app.use('/',router);

http.listen(3000, "localhost", function(){
    console.log("Listening on 3000");
});

io.on('connection',function(socket){
    socket.on('commend added',function(data){

    });
});