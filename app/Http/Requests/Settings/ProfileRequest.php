<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileRequest extends FormRequest
{
	
	public function authorize()
    {
        return true;
    }
	//Rule::unique('categories')->ignore($this->route('id'))
	public function rules()
	{
		return [
            'user_id' => 'nullable|int',
			'username' => 'required|string',
			'nickname' => 'required|string',
			'f_name' => 'nullable|string',
			'name' => 'nullable|string',
			'l_name' => 'nullable|string',
			'email' => 'required|email',
			'phone' => 'nullable|string'
		];
	}
	
	public function messages(){
		return [
			'username.required' => 'Поле fio должно быть заполнено',
			'username.string' => 'Поле fio имеет неправильный формат',
			'username.min' => 'Поле fio должно быть не менее 10 символов',
			'username.max' => 'Поле fio превышает допустимую длину'
		];
	}
	
	public function  attributes()
	{
		return [
			// 'media' => 'Контент',
			// 'content' => 'Текст',
			// 'votes' => 'Голосавание',
			// 'marked_users' => 'Отметки',
			// 'proportions' => 'Пропорции',
			// 'permissions' => 'Видимость',
			// 'post_id' => 'Номер поста'
		];
	}

	protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors()->all(), 403)); 
	}
	
}
?>