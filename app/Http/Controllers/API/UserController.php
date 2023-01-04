<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (Auth::user() == null) return response(['message' => 'Unauthenticated']);
            return $next($request);
        });
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {
        $current = User::find(Auth::user()->id);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user() == null) return response(['message' => 'Unauthenticated']);
        User::destroy($id);
        return response(['message' => 'User deleted']);
    }
}