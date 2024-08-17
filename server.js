const app  = require("express")();
const http = require("http").createServer(app);
const io   = require("socket.io")(http);

const PORT = 4444;

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

    socket.on("disconnect",function(){
        console.log("birileri geldi ve gitti.");
    });
});

http.listen(PORT,() => {
   console.log(PORT + " dinleniyor.")
})
