<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

// Route::get('/numtostring/{num}', function($num){
// 	return NUMtoSTRING($num);
// });

// Route::get('/stringtonum/{num}', function($num){
// 	return STRINGtoNUM($num);
// });

// Route::get('/versions/last-version', [ContentController::class, 'lastVersion']);

// Route::middleware(['auth:sanctum', 'limited'])->get('/follow/{id}', [ContentController::class, 'follow'])->name('follow');
// Route::middleware(['auth:sanctum', 'limited'])->get('/follow/delete/{id}', [ContentController::class, 'unfollow'])->name('follow');
// Route::post('/sms/send-code', [SmsController::class, 'sendCode']);
// Route::post('/sms/verify-code', [SmsController::class, 'verifyCode']);
// Route::middleware(['auth:sanctum'])->post('/groups/settings', [ContentController::class, 'groupsSettingsSave']);
// Route::middleware(['auth:sanctum'])->get('/groups', [ContentController::class, 'groupsList']);
// Route::middleware(['auth:sanctum'])->get('/rules', [ContentController::class, 'rulesList']);

// Route::get('/groups', [ContentController::class, 'groupsList']);
// Route::get('/rules', [ContentController::class, 'rulesList']);

// Route::middleware(['auth:sanctum'])->get('/comment/like/{item_id}', [CommentsController::class, 'comment_like'])->name('comment_like'); 
// Route::middleware(['auth:sanctum'])->get('/comment/unlike/{item_id}', [CommentsController::class, 'comment_unlike'])->name('comment_unlike'); 
// Route::middleware('auth:sanctum')->post('/users/checkusername/{username}', [UserController::class, 'checkusername'])->name('showolder');
// Route::middleware('auth:sanctum')->post('/users/complain', [UserController::class, 'complainUser'])->name('complainUser');
// Route::middleware('auth:sanctum')->get('/users/followers/{user_id}', [UserController::class, 'followers'])->name('followers');
// Route::middleware('auth:sanctum')->get('/users/blocked/{user_id}', [UserController::class, 'blocked'])->name('blocked');
// Route::middleware('auth:sanctum')->get('/users/follows/{user_id}', [UserController::class, 'follows'])->name('followers');
// Route::middleware('auth:sanctum')->get('/confirmation/confirmation-requests', [UserController::class, 'confirmationRequests'])->name('confirmationRequests');
// Route::middleware('auth:sanctum')->get('/confirmation/verify-account/{user_id}', [UserController::class, 'verifyAccount'])->name('verifyAccount');
// Route::middleware('auth:sanctum')->get('/confirmation/do-not-confirm-account/{user_id}', [UserController::class, 'doNotConfirmAccount'])->name('doNotConfirmAccount');

// Route::get('/teips/search', [SearchController::class, 'searchTeip'])->name('searchTeip');

// /*end site spi*/
// Route::middleware('auth:sanctum')->post('/user/savetoken', [UserController::class, 'saveFirebaseToken']);
// Route::middleware('auth:sanctum')->post('/user/removetoken', [UserController::class, 'removeFirebaseToken']);
// Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUserByToken']);
// Route::middleware('auth:sanctum')->get('/user/{user_id}', [UserController::class, 'getUserById']);
// Route::middleware('auth:sanctum')->get('/user/{user_id}/info', [UserController::class, 'getUserInfoById']);
// Route::middleware('auth:sanctum')->get('/user/{user_id}/posts', [UserController::class, 'getUserInfoWithPostsById']);

// Route::middleware('auth:sanctum')->get('/wall', [WallController::class, 'wall_index'])->name('wall_index');
// Route::middleware('auth:sanctum')->get('/wall/post/{id}', [WallController::class, 'wall_post'])->name('wall_post');
// Route::middleware('auth:sanctum')->get('/wall/like/{item_id}', [WallController::class, 'wall_like'])->name('wall_like');
// Route::middleware('auth:sanctum')->get('/wall/like/{item_id}/list', [WallController::class, 'likesList'])->name('wall_like');
// Route::middleware('auth:sanctum')->get('/wall/unlike/{item_id}', [WallController::class, 'wall_unlike'])->name('wall_unlike');
// Route::middleware('auth:sanctum')->get('/wall/users/{id}', [WallController::class, 'wall_user'])->name('wall_user');
// Route::middleware('auth:sanctum')->get('/wall/user/{id}', [WallController::class, 'wall_user'])->name('wall_user');
// Route::middleware('auth:sanctum')->get('/wall/delete/{item_id}', [WallController::class, 'wall_delete'])->name('wall_delete');
// Route::middleware('auth:sanctum')->post('/wall/vote/{id}', [WallController::class, 'wall_vote'])->name('wall_vote');
// Route::middleware('auth:sanctum')->get('/wall/vote/{post_id}/list', [WallController::class, 'votesList'])->name('votesList');
// Route::middleware('auth:sanctum')->get('/wall/deaths/{post_id}/list', [WallController::class, 'deathsList'])->name('deathsList');
// Route::middleware('auth:sanctum')->get('/wall/{action}/{id}', [WallController::class, 'run'])->name('wall_pages');
// Route::middleware('auth:sanctum')->post('/wall/store', [WallController::class, 'storeApp'])->name('store');

// /*Жалобы*/
// Route::middleware('auth:sanctum')->get('/complaint/reasons/{reason}', [ContentController::class, 'reasons'])->name('reasons');
// Route::middleware('auth:sanctum')->post('/complaint', [ContentController::class, 'sendComplaint'])->name('sendComplaint');
// Route::middleware('auth:sanctum')->get('/complaints', [ContentController::class, 'complaintsList'])->name('complaintsList');
// Route::middleware('auth:sanctum')->post('/complaints/considered/{complaint_id}', [ContentController::class, 'complaintsСonsidered'])->name('complaintsСonsidered');
// Route::middleware('auth:sanctum')->get('/complaints/delete/{complaint_id}', [ContentController::class, 'deleteСonsidered'])->name('deleteСonsidered');

// Route::middleware('auth:sanctum')->post('/comments/submit', [CommentsController::class, 'store'])->name('comment_add');
// Route::middleware('auth:sanctum')->post('/comments/delete/', [CommentsController::class, 'delete'])->name('comment_delete');
// Route::middleware('auth:sanctum')->get('/comments/{id}/{source}', [CommentsController::class, 'get_comments'])->name('get_comments');
// Route::middleware('auth:sanctum')->get('/comments/{id}/{source}/{parent_id}', [CommentsController::class, 'get_comments_childs'])->name('get_comments');
// Route::middleware('auth:sanctum')->get('/comments/get', [CommentsController::class, 'get'])->name('comment_get');

// Route::middleware('auth:sanctum')->get('/modules/index/{name}', [ModulesController::class, 'index'])->name('module_index');

// Route::middleware('auth:sanctum')->get('/follow/{id}', [ContentController::class, 'follow'])->name('follow');

//  /*сообщения*/
// Route::middleware('auth:sanctum')->get('/chats', [MessagesController::class, 'chats'])->name('chats');
// Route::middleware('auth:sanctum')->get('/chats/addchat/{id}', [MessagesController::class, 'addchat'])->name('addchat');
// Route::middleware('auth:sanctum')->get('/messages/acceptcontact/{id}', [MessagesController::class, 'acceptcontact'])->name('acceptcontact');
// Route::middleware('auth:sanctum')->post('/messages/contactcomplain/{id}', [MessagesController::class, 'contactComplain'])->name('contactcomplain');
// Route::middleware('auth:sanctum')->get('/messages/ignorecontact/{id}', [MessagesController::class, 'ignorecontact'])->name('ignorecontact');
// Route::middleware('auth:sanctum')->get('/messages/stopignorecontact/{id}', [MessagesController::class, 'stopignorecontact'])->name('stopignorecontact');
// Route::middleware('auth:sanctum')->get('/chat/{id}', [MessagesController::class, 'chat'])->name('chat');
// Route::middleware('auth:sanctum')->get('/messages/delete', [MessagesController::class, 'deleteMessages'])->name('deleteMessages');
// Route::middleware('auth:sanctum')->post('/messages/send', [MessagesController::class, 'send'])->name('send');
// Route::middleware('auth:sanctum')->put('/messages/send', [MessagesController::class, 'send'])->name('voice');
// Route::middleware('auth:sanctum')->post('/messages/setreaded', [MessagesController::class, 'setreaded'])->name('setreaded');
// Route::middleware('auth:sanctum')->post('/messages/showolder', [MessagesController::class, 'showolder'])->name('showolder');
// Route::middleware('auth:sanctum')->post('/messages/search', [MessagesController::class, 'search'])->name('search');
// Route::middleware('auth:sanctum')->post('/messages/getrangemessages', [MessagesController::class, 'getRangeMessages'])->name('getRangeMessages');
// Route::middleware('auth:sanctum')->get('/messages/delete/{message_id}', [MessagesController::class, 'delete'])->name('delete');
// Route::middleware('auth:sanctum')->post('/messages/delete', [MessagesController::class, 'delete_store'])->name('delete_store');
// Route::middleware('auth:sanctum')->get('/messages/forward/{message_id}', [MessagesController::class, 'forward'])->name('forward');
// Route::middleware('auth:sanctum')->get('/messages/forwardlist', [MessagesController::class, 'forwardlist'])->name('forwardlist');
// Route::middleware('auth:sanctum')->post('/messages/forwardlist', [MessagesController::class, 'forwardmessages'])->name('forwardmessages');
// Route::middleware('auth:sanctum')->post('/messages/forwardmedia', [MessagesController::class, 'forwardmedia'])->name('forwardmedia');
// Route::middleware('auth:sanctum')->post('/messages/forward', [MessagesController::class, 'forward_store'])->name('forward_store');
// Route::middleware('auth:sanctum')->post('/messages/mute', [MessagesController::class, 'mute'])->name('mute');
// Route::middleware('auth:sanctum')->get('/messages/loadContactMedia/{contact_id}', [MessagesController::class, 'loadContactMedia'])->name('loadContactMedia');
// Route::middleware('auth:sanctum')->get('/messages/deletechat/{contact_id}', [MessagesController::class, 'deletechat'])->name('deletechat');

//  /*события*/
// Route::post('/events/store', [EventsController::class, 'store'])->middleware(['auth:sanctum', 'permissions:events|add'])->name('storeEvent');
// Route::middleware('auth:sanctum')->get('/events/moderate', [EventsController::class, 'moderateList'])->name('moderateList');
// Route::post('/events/{event_id}', [EventsController::class, 'updateEvent'])->middleware(['auth:sanctum', 'permissions:events|add'])->name('updateEvent');
// Route::delete('/events/{event_id}', [EventsController::class, 'deleteEvent'])->middleware(['auth:sanctum', 'permissions:events|add'])->name('deleteEvent');
// Route::middleware('auth:sanctum')->get('/events', [EventsController::class, 'events'])->name('events');
// Route::middleware('auth:sanctum')->get('/v1.1/events', [EventsController::class, 'events1'])->name('events');
// Route::middleware('auth:sanctum')->get('/events/{id}', [EventsController::class, 'event'])->name('event');
// Route::middleware('auth:sanctum')->delete('/events/{event_id}/remind', [ContentController::class, 'togglereminder'])->name('togglereminder');
// Route::middleware('auth:sanctum')->put('/events/{event_id}/remind', [ContentController::class, 'togglereminder'])->name('togglereminder');
// Route::middleware('auth:sanctum')->get('/events/moderate/{event_id}/{status}', [EventsController::class, 'moderate'])->name('moderate');
// Route::middleware(['auth:sanctum', 'limited'])->get('/subscribe/{id}', [ContentController::class, 'subscribe'])->name('subscribe');

// /*Уведомления*/
// Route::middleware('auth:sanctum')->get('/notifications', [ContentController::class, 'notifications'])->name('notifications');
// Route::middleware('auth:sanctum')->post('/notifications/setreaded', [NotificationsController::class, 'notificationsSetReaded'])->name('notifications');

// /*поиск*/
// Route::middleware('auth:sanctum')->get('/search', [SearchController::class, 'search'])->name('search');
// Route::get('/search/search_user_by_name', [SearchController::class, 'searchUserByName'])->name('search');
// Route::get('/trusted-users/search', [SearchController::class, 'getTrsuted'])->name('getTrsuted');
// Route::get('/getregid', [SearchController::class, 'getlist'])->name('getlist');
// Route::get('/content/getregid', [SearchController::class, 'getlist'])->name('getlist');
// Route::middleware('auth:sanctum')->get('/getid', [SearchController::class, 'getid'])->name('getid');
// Route::middleware('auth:sanctum')->post('/getid', [SearchController::class, 'getid'])->name('getid');
// Route::middleware('auth:sanctum')->get('/searchalternaterelated/{id1}/{id2}', [SearchController::class, 'alternateRelated'])->name('alternateRelated');
// Route::middleware('auth:sanctum')->get('/searchrelated/{id1}/{id2}', [SearchController::class, 'related'])->name('searchrelated');
// Route::middleware('auth:sanctum')->post('/searchrelated/{id1}/{id2}', [SearchController::class, 'related'])->name('searchrelated');
// Route::middleware('auth:sanctum')->post('/spoucerelated/{id1}/{id2}', [SearchController::class, 'spoucerelated'])->name('searchrelated');
// Route::middleware('auth:sanctum')->post('/loadrelatedtree', [SearchController::class, 'loadrelatedtree'])->name('loadrelatedtree');

// /*дерево*/
// Route::middleware('auth:sanctum')->get('/tree/getsourceitem/{node_id}', [TreeController::class, 'getSourceItemInfo'])->name('getsourceitem');
// Route::get('/users/teips', [ContentController::class, 'teips'])->name('teips');
// Route::get('/teips', [ContentController::class, 'teips'])->name('teips');
// Route::middleware('auth:sanctum')->get('/teips/add', [ContentController::class, 'addTeip'])->name('addTeip');
// Route::middleware('auth:sanctum')->post('/teips', [ContentController::class, 'saveTeip'])->name('addTeip');
// Route::middleware('auth:sanctum')->delete('/teips', [ContentController::class, 'deleteTeip'])->name('addTeip');
// Route::middleware('auth:sanctum')->get('/tree/delete/{item_id}', [ContentController::class, 'deleteItem'])->name('deleteItem');
// Route::middleware('auth:sanctum')->get('/users/tree/{id}', [ContentController::class, 'tree'])->name('tree');
// Route::middleware('auth:sanctum')->get('/tree/{id}', [ContentController::class, 'tree'])->name('tree');
// //Route::middleware('auth:sanctum')->get('/tree/add/{id}/{source}', [ContentController::class, 'add'])->name('add');
// //Route::middleware('auth:sanctum')->get('/tree/add', [ContentController::class, 'add'])->name('add');
// Route::middleware('auth:sanctum')->get('/tree/node/{node_id}', [ContentController::class, 'node'])->name('tree_node');
// Route::middleware('auth:sanctum')->get('/node/{node_id}', [ContentController::class, 'getNode'])->name('tree_node');
// Route::middleware('auth:sanctum')->post('/tree/add', [TreeAddController::class, 'addNode'])->name('addNode');
// Route::middleware('auth:sanctum')->post('/tree/edit', [TreeEditController::class, 'editNode'])->name('editNode');
// Route::middleware('auth:sanctum')->get('/gargalo', [ContentController::class, 'gargalo'])->name('gargalo');
// Route::middleware('auth:sanctum')->get('/gargalo/{id}/{surf_id}', [ContentController::class, 'gargalo'])->name('gargalo');
// //Route::middleware('auth:sanctum')->get('/trusted', [UserController::class, 'trustedUsers'])->name('trustedUsers'); 
// Route::middleware('auth:sanctum')->get('/trusted-users', [UserController::class, 'trustedUsers'])->name('trustedUsers'); 
 
// Route::middleware('auth:sanctum')->get('/send-verify-request/{user_id}', [UserController::class, 'sendVerifyRequest'])->name('sendVerifyRequest'); 

// Route::middleware('auth:sanctum')->delete('/settings/avatar/delete', [SettingsController::class, 'deleteAvatar'])->name('deleteAvatar');
// Route::middleware('auth:sanctum')->post('/settings/profile', [SettingsController::class, 'profile_store'])->name('profile_store');
// Route::middleware('auth:sanctum')->post('/settings/security', [SettingsController::class, 'security_store'])->name('security_store');
// Route::middleware('auth:sanctum')->get('/notifications/groups', [NotificationsController::class, 'notificationsGroups'])->name('notificationsGroups');
// Route::middleware('auth:sanctum')->post('/settings/notifications', [SettingsController::class, 'notifications_store'])->name('security_store');
// Route::middleware('auth:sanctum')->get('/settings/get-notifications', [SettingsController::class, 'get_notifications'])->name('get_notifications');

// Route::middleware('auth:sanctum')->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::middleware('auth:sanctum')->get('/notactivate', [ContentController::class, 'notactivate'])->name('notactivate');

Route::prefix('sanctum')->namespace('API')->group(function() {
    return 'access1';
    //Route::middleware('auth:sanctum')->post('register', 'AuthController@register');
    Route::post('token', [AuthenticatedSessionController::class, 'token']);
});
// Route::post('/register', [RegisteredUserController::class, 'store'])
//                 ->middleware('guest');
				
// Route::get('/{username}', [UserController::class, 'username']);
