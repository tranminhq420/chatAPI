<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


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
        return response()->json($response);
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
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        try {
            DB::beginTransaction();
            $user = new User();
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->rmb_token = Str::random(10);
            $user->save();
            DB::commit();
        } catch (\Exception $exc) {
            // return response(['error' => $exc->getMessage()]);
            Log::info('Create user' . $exc);

            DB::rollback();
        }

        $response = [
            'message' => 'user_created',
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response(['message' => 'User deleted']);
    }
}