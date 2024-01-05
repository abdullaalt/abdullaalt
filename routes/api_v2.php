<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\V1\UsersController;
use App\Http\Controllers\V1\WallController;
use App\Http\Controllers\V1\SettingsController;
use App\Http\Controllers\V1\EventsController;


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

/*site api*/

Route::prefix('sanctum')->group(function() {
    Route::post('token', [AuthenticatedSessionController::class, 'token']);
});

Route::middleware(['auth:sanctum'])->prefix('users')->group(function() {
    Route::get('/', [UsersController::class, 'getUserByToken']);
    Route::get('/user/{user_id}', [UsersController::class, 'getUserById']);
});

Route::middleware(['auth:sanctum'])->prefix('events')->group(function() {
    Route::get('/', [EventsController::class, 'events']);
    Route::get('/{event_id}', [EventsController::class, 'getEvent']);
    //Route::get('/user/{user_id}', [UsersController::class, 'getUserById']);
});

Route::middleware(['auth:sanctum'])->prefix('settings')->group(function() {
    Route::post('/profile', [SettingsController::class, 'saveProfile']);
    Route::delete('/avatar', [SettingsController::class, 'deleteAvatar']);
    Route::post('/avatar', [SettingsController::class, 'uploadAvatar']);
    Route::get('/user/{user_id}', [UsersController::class, 'getUserById']);
});

Route::middleware(['auth:sanctum'])->prefix('comments')->group(function() {
    Route::post('/store', [CommentsController::class, 'store']);
    Route::delete('/{comment_id}', [CommentsController::class, 'deleteComment']);
    Route::get('/{source_id}/{source}', [CommentsController::class, 'getSourceCommentsList']);
    Route::get('/{source_id}/{source}/{parent_id}', [CommentsController::class, 'getSourceSubCommentsList']);
});

Route::middleware(['auth:sanctum'])->prefix('wall')->group(function() {
    Route::get('/', [WallController::class, 'getWall']);
    Route::post('/store', [WallController::class, 'store']);
    Route::get('/vote/{post_id}/list', [WallController::class, 'postVotedUsersList']);
    Route::get('/vote/{var_id}', [WallController::class, 'voteVar']);
    Route::get('/vote/{var_id}/cancel', [WallController::class, 'cancelVar']);
    Route::get('/post/{post_id}', [WallController::class, 'getPost']);
    Route::get('/user/{user_id}', [WallController::class, 'getUserWall']);
    Route::get('/like/{post_id}/list', [WallController::class, 'postLikesList']);
    Route::get('/like/{post_id}', [WallController::class, 'postLike']);
});

Route::get('/numtostring/{num}', function($num){
	return NUMtoSTRING($num);
});

Route::get('/stringtonum/{num}', function($num){
	return STRINGtoNUM($num);
});

//Route::get('/versions/last-version', [ContentController::class, 'lastVersion']);



Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');
				
//Route::get('/{username}', [UserController::class, 'username']);
