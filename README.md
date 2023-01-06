### POST - /api/users
    Creates a new user and returns a userID
    
    Header:
    Content-Type : application/json

    Body:
    {
    "username" : "%username%",
    "password" : "%password%"
    }
    Response body:
    {
    "message" : "User created"
    }

### GET - /api/users
    Returns a list of all users
    
    Header:
    Token : "%Auth Token%"

    Response body:
    {
    "users" : [
    {
    "id" : "%userID%",
    "username" : "%username%"
    }
    ]
    }

### GET - /api/user/:userID
    Returns a user
    
    Header:
    Token : "%Auth Token%"

    Response body:
    {
    "user" : {
    "username" : "%username%",
    "id" : "%userID%",
    "ownedRooms" : [ "%roomID%" ],
    "rooms" : [ "%roomID%" ]
    }
    }

###DELETE - /api/user/:userID
    Deletes a user specified by the userID
    
    Header:
    Token : "%Auth Token%"

    Response body:
    {
    "message" : "User deleted"
    }

###POST - /api/rooms
    Creates a chat room
    
    Header:
    Token: %tokenID%

    Body:
    {
    "name" : "%room name%"
    }
    Response body:
    {
    "message" : "Room created"
    }

###GET - /api/rooms
    Gets all chat rooms
    
    Header:
    Token : "%Auth Token%"

    Response body:
    {
    "rooms" : [
    {
    "id" : "%roomID%",
    "name" : "%room name%",
    "joined": true
    }
    ]
    }

###GET - /api/room/:roomID
    Get room
    
    Header:
    Token : "%Auth Token%"

    Response Body:
    {
    "room": {
    "id": "%roomID%",
    "name": "%room name%",
    "admin": "%userID%",
    "users": [
    "%userID%"
    ],
    "messages": [
    {
    "sender": "%user name%",
    "message": "%message%"
    }
    ]
    }
    }

###DELETE - /api/room/:roomID
    Delete room
    
    Header:
    Token : %tokenID%

    Response body:
    {
    "message" : "Room deleted"
    }

###POST - /api/room/:roomID/users
    Add user to room
    
    Header:
    Token : %tokenID%

    Body:
    {
    "user" : "%userID%",
    }
    Response body:
    {
    "message" : "Added user to room"
    }

###GET - /api/room/:roomID/users
    Get all users in room
    
    Header:
    Token : "%Auth Token%"

    Response body:
    {
    "users" : [
    {
    "id" : "%userID%",
    "username" : "%username%"
    }
    ]
    }

###GET - /api/room/:roomID/messages
    Get all messages in room
    
    Header:
    Token : %tokenID%

    Response body:
    {
    "messages" : [
    {
    "id" : "%messageID%",
    "message" : "%message%",
    "author" : "%userID%",
    "time" : "%time sent%"
    }
    ]
    }
    
###GET - /api/room/:roomID/:userID/messages
    Get all messages by user in room
    
    Header:
    Token : %tokenID%

    Response body:
    {
    "messages" : [
    {
    "id" : "%messageID%",
    "message" : "%message%",
    "author" : "%userID%",
    "time" : "%time sent%"
    }
    ]
    }

###POST - /api/room/:roomID/:userID/messages
    Add message to room
    
    Header:
    Token : %tokenID%

    Body:
    {
    "message" : "%message%"
    }
    Response body:
    {
    "message" : "Message sent"
    }
