<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatroomController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUsers($id)
    {
        $current = User::find($id);
        $users = User::get(['id', 'username']);
        $response = [
            'users' => $users
        ];
        return response()->json($response)->header('Auth', $current->token);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUsersRoom($id)
    {
        $users = User::with('rooms')->where('users.id', '=', $id)->get();

        $responses = array();
        $response = array();
        foreach ($users as $user) {
            $response['id'] = $user->id;
            $response['username'] = $user->username;
            $response['rooms'] = array();
            $rooms = $user->rooms()->get();
            foreach ($rooms as $room) {
                array_push($response['rooms'], $room->id);
            }
            $response['owned_rooms'] = array();
            $ownedRooms = Room::select('rooms.id')->where('rooms.admin_id', '=', $user->id)->get();
            foreach ($ownedRooms as $owned) {
                array_push($response['owned_rooms'], $owned->id);
            }
            array_push($responses, $response);
        }

        return response()->json($responses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->username = $request->username;
            $user->password = $request->password;
            $user->token = Str::random(50);
            $user->save();
            DB::commit();
        } catch (\Exception $exc) {
            Log::info('Create user' . $exc);
            DB::rollback();
        }
        $response = [
            // 'user' => $user,
            'message' => 'user_created',
        ];
        return response()->json($response)->header('Content-Type', 'application/json');
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