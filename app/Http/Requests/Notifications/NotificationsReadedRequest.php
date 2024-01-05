<?php

namespace App\Http\Requests\Notifications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NotificationsReadedRequest extends FormRequest
{
	
	public function authorize()
    {
        return true;
    }
	//Rule::unique('categories')->ignore($this->route('id'))
	public function rules()
	{
		return [
			'list'=> ['required', 'array'],
			'list.*'=> ['integer']
		];
	}
	
	public function messages(){
		return [
			'list.required' => 'Поле list должно быть заполнено'
		];
	}
	
	public function  attributes()
	{
		return [
			'list' => 'список'
		];
	}

	protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()->all()], 403)); 
	}
	
}
?>