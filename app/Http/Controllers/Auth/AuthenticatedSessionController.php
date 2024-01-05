<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\V1\User\User;

use App\Services\V1\Users\UserService;
use App\Services\V1\Users\CentrifugeService;

use App\Http\Resources\V1\Users\UserSimpleResource;

use Response;
use Errors;
 
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
		
		$headers = getallheaders();
		$user = Auth::user();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
	
	public function token(Request $request)
	{
		
		$values =  $request->all();
		
		$validator = Validator::make($values, [
			'email' => ['required', 'string', 'email', 'max:255'],
			'password' => ['required', 'string', 'min:6'],
			'device_name' => ['required', 'string']
		]);    
		
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}
		// 1
	 
		$user_model = User::where('email', $values['email'])->first();
		// 2
	 //return response()->json($user, 400);
		if (!$user_model || !Hash::check($values['password'], $user_model->password)) {
			return (new Response((new Errors(
                [Response::getLangValue('NOT_VALID_DATA')]
            ))->get(), 401))->json();
		}
		
		$user = (new UserService())->getUser($user_model->id);

		if ($user->response()->isFail()){
			return $user->response()->json();
		}

		$centrifuge = new CentrifugeService($user->get('id'));

		$user->addProperty('cent_token', $centrifuge->getToken());
		$user->addProperty('channel', $centrifuge->getChannel());
		$user->addProperty('token', $user_model->createToken($values['device_name'])->plainTextToken);
	 
		return $user->addDataToResponse(UserSimpleResource::class)->response()->json();

		return response()->json([
				'token' => $user->createToken($values['device_name'])->plainTextToken,
				"is_admin"=> $user->is_admin ? true : false,
				"email"=> $user->email,
				"cent_token"=> @$centrifuge_info->token,
				"channel"=> @$centrifuge_info->channel,
				"nickname"=> $user->nickname,
				"username"=> $user->username,
				"avatar"=> '/storage/app/'.print_image_src($user->profile_photo_path, 'medium'),
				"is_real"=> $user->is_real ? true : false,
				"f_name"=> $user->f_name,
				"name"=> $user->name,
				"l_name"=> $user->l_name,
				"born"=> $user->born,
				"phone"=> $user->photo,
				"node_id"=> $user->tree_number,
				"node_id"=> $user->tree_number,
				"gender"=> $user->pol == 2 ? 'female' : 'male',
				"user_id"=> $user->id]);
		// 4
	}

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
