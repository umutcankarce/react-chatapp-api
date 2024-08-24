const app  = require("express")();
const http = require("http").createServer(app);
const io   = require("socket.io")(http);

const PORT = 4444;

const users = {};
const privateUsers = {}; // homepage user connection

io.on("connection",function(socket){

    // user socket connection
    socket.on("connect_user",(data) => {

        if(!(data.userId in privateUsers)){
            privateUsers[data.userId] = {}
        }

        privateUsers[data.userId] = socket;
        socket.userId = data.userId;
    });

    // user message page trigger
    socket.on("add_user",function(data){
        if(!(data.sender_id in users)){
            users[data.sender_id] = {};
        }

        users[data.sender_id][data.message_id] = socket;
        socket.sender_id = data.sender_id;
        socket.message_id = data.message_id;
    });

    // message send
    socket.on("send_message",function(data) {
        if(data.receiver_id in users){
            if(data.message_id in users[data.receiver_id]){
                users[data.receiver_id][data.message_id].emit("message_show",{
                    "mgc_sender"  : data.sender_id,
                    "mgc_content" : data.message
                })
            }
        }
    });

    // notification message send
    socket.on("send_notification_message",function (data) {
        if(data.receiver_id in privateUsers){
            privateUsers[data.receiver_id].emit("message_notification",{
                "sender_id" : data.sender_id,
                "dont_read" : data.dont_read
            })
        }
    });

    socket.on("disconnect",function(){
        console.log("birileri geldi ve gitti.");
    });
});

http.listen(PORT,() => {
   console.log(PORT + " dinleniyor.")
})
