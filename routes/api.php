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

Route::post('/users', 'API\ChatroomController@createUser');
Route::get('/users/{id}', 'API\ChatroomController@getUsersRoom');
Route::get('/users/:userID', 'API\ChatroomController@getUsersRoom');