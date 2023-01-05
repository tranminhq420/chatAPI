<?php



use App\Http\Controllers\API\ChatroomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/users', 'API\UserController@createUser');

Route::get('/users/{id}', 'API\UserController@getUsers');
Route::get('/users/{id}/rooms', 'API\UserController@getUsersRoom');
Route::delete('/users/{id}', 'API\UserController@destroy');

Route::post('/rooms', 'API\RoomController@createRoom');
Route::get('/rooms', 'API\RoomController@getAllUserRoom');
Route::get('/rooms/{id}', 'API\RoomController@getRoom');
Route::delete('/rooms/{id}', 'API\RoomController@destroy');
Route::post('/rooms/{id}/users', 'API\RoomController@addUserToRoom');
Route::get('/rooms/{id}/users', 'API\RoomController@getAllUserInRoom');
Route::get('/rooms/{id}/messages', 'API\MessageController@getAllMessagesInRoom');
Route::get('/rooms/{roomID}/{userID}/messages', 'API\MessageController@getMessagesByUser');
Route::post('/rooms/{roomID}/{userID}/messages', 'API\MessageController@addMessage');