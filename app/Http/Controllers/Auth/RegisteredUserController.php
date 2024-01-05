<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ClientController;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
		$tree = DB::table('trees')->get();
		
        return view('auth.register', ['tree'=>$tree]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
		$data = $request->has('phone') ? $request->all() : $request->json()->all();
		//$data = json_decode($data, true);
		$headers = getallheaders();
		$app_id =isset($headers['User-Token']) || isset($headers['user-token']);
		
        $rules = [
            'f_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
		//return response()->json($request);
		$messages = [
			'required' => 'Поле должно быть заполнено'
		];
		if ($app_id){
			$values = $data;
		}else{
			$values = [];
			
			foreach ($data as $key=>$d){
				$values[$d['name']] = $d['value'];
			}
		}
		
		$validator = Validator::make($values, $rules, $messages);
		$errors = false;
		if ($validator->fails()) {
			//dd($validator->errors()->messages());
			foreach ($validator->errors()->messages() as $key=>$message) {
				$errors[$key] = $message;
			}
        }

        // Retrieve the validated input...
        //$validated = $validator->validated();
		
		$session_id = session()->getId();
		$phone = str_replace(['(', ')', ' ', '-', '+'], '', $values['phone']);
		
		$is_verify = DB::table('users_code')->where('phone', $phone)->where('is_verify', 1)->exists() ? true : false;
		if (!$is_verify){
			$errors['phone'][] = 'Номер телефона не подтвержден'; 
		}
		
		if ($errors){
			DB::table('users_code')->where('phone', $phone)->where('is_verify', 1)->update(['is_verify'=>0]);
			return $this->returnJSON([
				'errors' => $errors
			], false, 400);
		}

        $pol = $values['gender'] == 'male' ? 1 : 2;
		
        $user = User::create([
            'l_name' => $values['l_name'],
            'name' => $values['name'],
            'f_name' => $values['f_name'],
            'nickname' => implode(' ', array($values['f_name'], $values['name'], $values['l_name'])),
            'pol' => $pol,
            'gender' => $values['gender'],
            'born' => date('Y-m-d', strtotime($values['born'])),
            //'teip' => $values['teip'],
            'teip' => -1,
            'phone' => $phone,
            'tpl_tree_number' => $values['tpl_tree_number'],
            'tree_number' => -1,
            'email' => $values['email'],
            'password' => Hash::make($values['password']),
        ]);
		
		
		
		
		DB::table('users_groups_members')->insert(['user_id'=>$user->id, 'group_id'=>3]);
		DB::table('followers')->
						insert(array('user_id'=>$user->id, 'subs_id'=>8));
		DB::table('users')->where('id', $user->id)->update(['username' => 'user'.$user->id]);
        event(new Registered($user));
		
		if (isApp()){
			
			$client = new ClientController("https://gargalo.ru:8082/api");
			$client->setApiKey('cr43cr43crc4r43cr4k3ct9rr4c');
			$cent_token  =  $client->setSecret('x434x3434r43t5vt5vt5vx32rh')->generateConnectionToken($user->id);
			$channel = $client->getChanel($user->id*(-55));
			DB::table('centrifuge')->insert(array('user_id'=>$user->id, 'token'=>$cent_token, 'channel'=>$channel, 'source'=>'app'));
							
			$user_model = User::where('email', $values['email'])->first();
			$centrifuge_info = DB::table('centrifuge')->where('user_id', $user->id)->first();
			return $this->returnJSON([
				'token' => $user_model->createToken('mobile')->plainTextToken,
				"is_admin"=> false,
				"email"=> $values['email'],
				"cent_token"=> $cent_token,
				"channel"=> $channel,
				"nickname"=> $user->nickname,
				"username"=> 'user'.$user->id,
				"avatar"=> '/storage/app/'.print_image_src($user->profile_photo_path, 'medium'),
				"is_real"=> false,
				"f_name"=> $user->f_name,
				"name"=> $user->name,
				"l_name"=> $user->l_name,
				"born"=> $user->born,
				"phone"=> $user->photo,
				"node_id"=> $user->tree_number,
				"gender"=> $user->pol == 2 ? 'female' : 'male',
				"user_id"=> $user->id]);
		}		
		
        Auth::login($user);

        return $this->returnJSON($user);
    }
}
