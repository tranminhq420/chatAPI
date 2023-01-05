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

Route::post('/users', 'API\SignUpController@createUser');
Route::post('/tokens', 'API\SignUpController@login');
Route::group(['middleware' => ['cors', 'json.response', 'auth:api']], function () {
  Route::get('/users', 'API\UserController@getUsers');
  Route::get('/users/{id}', 'API\UserController@getUsersRoom');
  Route::delete('/users/{id}', 'API\UserController@destroy');
  Route::get('/tokens', 'API\PassportController@getToken');
  Route::delete('/tokens/{id}', 'API\PassportController@revokeAccessToken');
  Route::post('/rooms', 'API\RoomController@createRoom');
  Route::get('/rooms', 'API\RoomController@getAllUserRoom');
  Route::get('/rooms/{id}', 'API\RoomController@getRoom');
  Route::delete('/rooms/{id}', 'API\RoomController@destroy');
  Route::post('/rooms/{id}/users', 'API\RoomController@addUserToRoom');
  Route::get('/rooms/{id}/users', 'API\RoomController@getAllUserInRoom');
  Route::get('/rooms/{id}/messages', 'API\MessageController@getAllMessagesInRoom');
  Route::get('/rooms/{roomID}/{userID}/messages', 'API\MessageController@getMessagesByUser');
  Route::post('/rooms/{roomID}/{userID}/messages', 'API\MessageController@addMessage');
  Route::get('/user', function (Request $request) {
    $user = $request->user();
    dd($user);
    $accessToken = $user->token;
    return response($accessToken);
  });
});