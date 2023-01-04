<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Message;

class MessageController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMessage($roomId, $userId, Request $request)
    {
        $tokenId = $request->header('Token');

        $accessToken = DB::table('oauth_access_tokens')
            ->where('id', $tokenId)
            ->first();

        if (!$accessToken) {
            return response()->json([
                'error' => 'Access token not found.',
            ], 401);
        }
        // Check if the authenticated user is the user specified in the URL
        if ($accessToken->user_id != $userId) {
            return response()->json([
                'error' => 'Unauthorized.',
            ], 401);
        }

        // Add the message to the room
        $message = new Message();
        $message->room_id = $roomId;
        $message->user_id = $userId;
        $message->body = $request->input('message');
        $message->save();

        return response()->json([
            'message' => 'Message sent',
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllMessagesInRoom($id)
    {
        $room = Room::find($id);
        $messages = $room->messages;
        $response = array();
        foreach ($messages as $message) {
            array_push($response, [
                'messages' => [
                    'id' => $message->id,
                    'message' => $message->body,
                    'author' => $message->users->id,
                    'time' => $message->created_at
                ]
            ]);
        }
        return response($response);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMessagesByUser($roomID, $userID)
    {
        $messages = DB::table('messages')->join('rooms', 'rooms.id', '=', 'messages.room_id')->join('users', 'users.id', '=', 'messages.user_id')->where('user_id', $userID)->where('room_id', $roomID)->select(['messages.id as id', 'messages.body as message', 'users.id as author', 'messages.created_at as time'])->get();
        return response(['messages' => $messages]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}