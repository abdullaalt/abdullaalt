<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\SmsController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('users', [UserController::class, 'index']);
Route::get('/', function () {
    return redirect()->route('wall_index');
});

Route::get('/privacy-policy', function () {
    return 'commin soon';
});
Route::get('/user-agreement', function () {
    return 'commin soon';
});
Route::get('/personal-data', function () {
    return 'commin soon';
});
Route::get('/cookie-policy', function () {
    return 'commin soon';
});

Route::get('/parse/rebuild/{id}', [ParserController::class, 'rebuild'])->middleware(['auth', 'limited'])->name('rebuild');
Route::get('/parse', [ParserController::class, 'parselist'])->middleware(['auth', 'limited'])->name('parselist');
Route::get('/parse/{from_category_id}/{to_category_id}', [ParserController::class, 'parse'])->middleware(['auth', 'limited'])->name('parse');

Route::get('/esia/auth', [UserController::class, 'esia'])->name('esia');
Route::post('/esia/api', [UserController::class, 'dapi'])->name('dapi');

Route::post('/comments/submit', [CommentsController::class, 'store'])->middleware(['auth', 'limited'])->name('comment_add');
Route::get('/comments/delete/', [CommentsController::class, 'delete'])->middleware(['auth', 'limited'])->name('comment_delete');
Route::get('/comments/get', [CommentsController::class, 'get'])->middleware(['auth', 'limited'])->name('comment_get');

Route::get('/modules/index/{name}', [ModulesController::class, 'index'])->middleware(['auth'])->name('module_index');

/*Биллинг*/
Route::middleware(['auth', 'limited'])->group(function () {
	Route::get('/billing', [BillingController::class, 'billing'])->name('billing');
	Route::get('/create-wallet', [BillingController::class, 'createWallet'])->name('create-wallet');
	Route::get('/billing/wallet/refill', [BillingController::class, 'refill'])->name('top-up');
	Route::post('/billing/wallet/refill', [BillingController::class, 'refillStore'])->name('top-up');
});

 /*сообщения*/
Route::middleware(['auth', 'permissions:chat|read'])->group(function () {
	Route::get('/chats', [MessagesController::class, 'chats'])->name('chats');
	Route::get('/addchat/{id}', [MessagesController::class, 'addchat'])->name('addchat');
	Route::get('/acceptcontact/{id}', [MessagesController::class, 'acceptcontact'])->name('acceptcontact');
	Route::get('/ignorecontact/{id}', [MessagesController::class, 'ignorecontact'])->name('ignorecontact');
	Route::get('/chat/{id}', [MessagesController::class, 'chat'])->name('chat');
	Route::post('/messages/send', [MessagesController::class, 'send'])->name('send');
	Route::post('/messages/setreaded', [MessagesController::class, 'setreaded'])->name('setreaded');
	Route::post('/messages/showolder', [MessagesController::class, 'showolder'])->name('showolder');
	Route::post('/messages/voice', [MessagesController::class, 'send'])->name('voice');
	Route::get('/messages/delete/{message_id}', [MessagesController::class, 'delete'])->name('delete');
	Route::post('/messages/delete', [MessagesController::class, 'delete_store'])->name('delete_store');
	Route::get('/messages/forward/{message_id}', [MessagesController::class, 'forward'])->name('forward');
	Route::post('/messages/forward', [MessagesController::class, 'forward_store'])->name('forward_store');
});

 /*события*/
Route::get('/events/add', [EventsController::class, 'addEvent'])->middleware(['auth', 'permissions:events|add'])->name('addEvent');
Route::get('/events/moderate/{event_id}', [EventsController::class, 'moderate'])->middleware(['auth', 'permissions:events|moderate'])->name('moderate');

Route::get('/events', [ContentController::class, 'events'])->middleware(['auth', 'permissions:events|read'])->name('events');
Route::get('/events/{id}', [EventsController::class, 'event'])->middleware(['auth', 'permissions:events|read'])->name('event');
Route::delete('/events/togglereminder/{event_id}', [ContentController::class, 'togglereminder'])->middleware(['auth', 'permissions:events|add'])->name('togglereminder');
Route::put('/events/togglereminder/{event_id}', [ContentController::class, 'togglereminder'])->middleware(['auth', 'permissions:events|add'])->name('togglereminder');
Route::get('/notifications', [ContentController::class, 'notifications'])->middleware(['auth', 'permissions:notifications|read'])->name('notifications');


/*поиск*/
Route::get('/search', [SearchController::class, 'search'])->middleware(['auth', 'permissions:search|read'])->name('search');
Route::get('/search/search_user_by_name', [SearchController::class, 'searchUserByName'])->middleware(['auth', 'permissions:search|read'])->name('search');
Route::get('/getregid', [SearchController::class, 'getlist'])->name('getlist');
Route::get('/getid', [SearchController::class, 'getid'])->middleware(['auth', 'permissions:search|read'])->name('getid');
Route::post('/getid', [SearchController::class, 'getid'])->middleware(['permissions:search|read'])->name('getid');
Route::get('/searchrelated/{id1}/{id2}', [SearchController::class, 'related'])->middleware(['auth', 'permissions:search|read'])->name('searchrelated');
Route::post('/searchrelated/{id1}/{id2}', [SearchController::class, 'related'])->middleware(['auth', 'permissions:search|read'])->name('searchrelated');
Route::post('/spoucerelated/{id1}/{id2}', [SearchController::class, 'spoucerelated'])->middleware(['auth', 'permissions:search|read'])->name('searchrelated');
Route::post('/loadrelatedtree', [SearchController::class, 'loadrelatedtree'])->middleware(['auth', 'permissions:search|read'])->name('loadrelatedtree');
Route::get('/loadrelatedtree', [SearchController::class, 'loadrelatedtree'])->middleware(['auth', 'permissions:search|read'])->name('loadrelatedtree');

/*дерево*/
Route::get('/teips', [ContentController::class, 'teips'])->name('teips');
Route::get('/teips/add', [ContentController::class, 'addTeip'])->middleware(['auth', 'limited'])->name('addTeip');
Route::get('/subscribe/{id}', [ContentController::class, 'subscribe'])->middleware(['auth', 'limited'])->name('subscribe');
Route::get('/tree/delete/{item_id}', [ContentController::class, 'deleteItem'])->middleware(['auth', 'limited'])->name('deleteItem'); 
Route::post('/teips/add', [ContentController::class, 'saveTeip'])->middleware(['auth', 'limited'])->name('addTeip');
Route::get('/tree/{id}', [ContentController::class, 'tree'])->name('tree');
Route::get('/tree/edit/{item_id}', [ContentController::class, 'edit'])->middleware(['auth', 'limited'])->name('edit');
Route::post('/tree/edit/', [ContentController::class, 'editNode'])->middleware(['auth', 'limited'])->name('editNode');
Route::get('/tree/add/{id}/{source}', [ContentController::class, 'add'])->middleware(['auth', 'limited'])->name('add');
Route::get('/tree/apply/{id}/{source}', [ContentController::class, 'apply'])->middleware(['auth', 'limited'])->name('apply');
//Route::get('/tree/add', [ContentController::class, 'add'])->middleware(['auth'])->name('add');
Route::get('/tree/node/{node_id}', [ContentController::class, 'node'])->middleware(['auth'])->name('tree_node');
Route::get('/node/{node_id}', [ContentController::class, 'node'])->middleware(['auth'])->name('tree_node');
Route::post('/tree/add', [ContentController::class, 'addNode'])->middleware(['auth', 'limited'])->name('addNode');
Route::get('/gargalo', [ContentController::class, 'gargalo'])->middleware(['auth'])->name('gargalo');
Route::get('/gargalo/{id}', [ContentController::class, 'gargalo'])->middleware(['auth'])->name('gargalo');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/*стена*/
Route::get('/wall', [WallController::class, 'wall_index'])->middleware(['auth'])->name('wall_index');
Route::get('/test', [WallController::class, 'run', ['action'=> 'test', 'item_id'=>false]])->middleware(['auth'])->name('wall_index'); 
Route::post('/wall', [WallController::class, 'run', ['action'=> 'index', 'item_id'=>false]])->middleware(['auth', 'permissions:wall|add'])->name('wall_index');
Route::get('/wall/delete/{id}', [WallController::class, 'wall_delete'])->middleware(['auth'])->name('wall_delete');
Route::get('/wall/post/{id}', [WallController::class, 'wall_post'])->middleware(['permissions:wall|read'])->name('wall_post');
Route::get('/wall/user/{id}', [WallController::class, 'wall_user'])->middleware(['permissions:wall|read'])->name('wall_user');
Route::get('/wall/vote/{id}', [WallController::class, 'wall_vote'])->middleware(['auth'])->name('wall_vote');
Route::get('/wall/{action}/{id}', [WallController::class, 'run'])->middleware(['auth'])->name('wall_pages');
Route::get('/wall/{action}/{reason}', [WallController::class, 'run'])->middleware(['auth'])->name('wall_blacklist_complaint');
Route::post('/wall/store', [WallController::class, 'store'])->middleware(['auth', 'limited', 'permissions:wall|add'])->name('store');

Route::get('/notactivate', [ContentController::class, 'notactivate'])->middleware(['auth'])->name('notactivate');
Route::get('/changelang', [LangController::class, 'changelang'])->middleware(['auth'])->name('changelang');

Route::get('/users/followers/{user_id}', [UserController::class, 'followers'])->middleware(['auth'])->name('followers');
Route::get('/users/savetokem', [UserController::class, 'savetokem'])->middleware(['auth'])->name('savetokem');
Route::get('/users/follows/{user_id}', [UserController::class, 'follows'])->middleware(['auth'])->name('follows');
Route::get('/users/{user_id}', [UserController::class, 'getProfile'])->middleware(['auth'])->name('user');
Route::get('/regqueries', [UserController::class, 'regqueries'])->middleware(['auth'])->name('regqueries');
Route::get('/users/set-trusted/{id}', [UserController::class, 'setTrusted'])->middleware(['auth'])->name('setTrusted');
Route::get('/users/stop-trusted/{id}', [UserController::class, 'stopTrusted'])->middleware(['auth'])->name('stopTrusted');
Route::get('/users/restart-trusted/{id}', [UserController::class, 'restartTrusted'])->middleware(['auth'])->name('restartTrusted');
Route::get('/users/acceptrequest/{id}', [UserController::class, 'acceptrequest'])->middleware(['auth'])->name('acceptrequest');
Route::get('/getcsrf', [UserController::class, 'getcsrf'])->name('getcsrf');

Route::get('/confirmation-requests', [UserController::class, 'confirmationRequests'])->middleware(['auth'])->name('confirmationRequests'); 
Route::get('/trusted-users', [UserController::class, 'trustedUsers'])->middleware(['auth'])->name('trustedUsers'); 
Route::get('/send-verify-request/{user_id}', [UserController::class, 'sendVerifyRequest'])->middleware(['auth'])->name('sendVerifyRequest'); 
Route::get('/verify-account/{user_id}', [UserController::class, 'verifyAccount'])->middleware(['auth'])->name('verifyAccount'); 
Route::get('/do-not-confirm-account/{user_id}', [UserController::class, 'doNotConfirmAccount'])->middleware(['auth'])->name('doNotConfirmAccount'); 
Route::get('/users/verify-data/{user_id}/{result}', [UserController::class, 'verifyData'])->middleware(['auth'])->name('verifyData'); 

Route::get('/settings', [SettingsController::class, 'run', ['action'=> 'index', 'item_id'=>false]])->middleware(['auth'])->name('setting_index'); 
Route::get('/settings/{action}', [SettingsController::class, 'run'])->middleware(['auth', 'limited'])->name('setting_action');
Route::get('/settings/{action}/{item_id}', [SettingsController::class, 'run'])->middleware(['auth'])->name('setting_action');
Route::post('/settings/notifications', [SettingsController::class, 'notifications_store'])->middleware(['auth', 'limited'])->name('notifications_store');
Route::post('/settings/security', [SettingsController::class, 'security_store'])->middleware(['auth', 'limited'])->name('security_store');
Route::post('/settings/profile', [SettingsController::class, 'profile_store'])->middleware(['auth', 'limited'])->name('profile_store');
//Route::post('/settings/profile', [SettingsController::class, 'profile_store'])->middleware(['auth', 'limited'])->name('profile_store');

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
 
    return "Кэш очищен.";
});

Route::post('/tokens/create', function (Request $request) {
	//dd($request);
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::get('/{username}', [UserController::class, 'username']);

require __DIR__.'/auth.php';
