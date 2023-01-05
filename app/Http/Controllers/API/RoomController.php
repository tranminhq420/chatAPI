<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Room;
use App\Http\Controllers\API\BaseController;
use App\Models\User;

class RoomController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRoom(Request $request, $userID)
    {
        $room = new Room();
        $room->name = $request->name;
        $room->admin_id = $userID;
        $response = ['message' => 'Room created'];
        $room->save();
        return response($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRoom($id)
    {
        $room = Room::find($id);
        $response = [
            "rooms" => [
                "id" => $room->id,
                "name" => $room->name,
                // "users" => $room->users
            ]
        ];
        $response['rooms']['users'] = array();
        $response['rooms']['messages'] = array();
        foreach ($room->users as $user) {
            array_push($response['rooms']['users'], $user->id);
        }
        $messages = $room->messages;
        // dd($messages);
        foreach ($messages as $message) {
            array_push($response['rooms']['messages'], [
                'sender' => $message->users->username,
                'message' => $message->body
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
    public function getAllUserRoom($id)
    {
        $users = User::find($id);
        $rooms = $users->rooms;
        $responses = array();
        $response = array();
        foreach ($rooms as $room) {
            $response['id'] = $room->id;
            $response['name'] = $room->name;
            $response['joined'] = true;
            array_push($responses, $response);
        }
        return response(['rooms' => $responses]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addUserToRoom(Request $request, $id)
    {
        $room = Room::find($id);
        $room->users()->attach($request->body);
        return response(['message' => 'Added user to room']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllUserInRoom($id)
    {
        $room = Room::find($id);
        $users = $room->users;
        $response['users'] = array();
        foreach ($users as $user) {
            array_push($response['users'], [
                'id' => $user->id,
                'username' => $user->username
            ]);
        }
        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Room::destroy($id);
        return response(['message' => 'Room deleted']);
    }
}