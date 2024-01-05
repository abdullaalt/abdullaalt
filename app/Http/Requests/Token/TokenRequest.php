<?php

namespace App\Http\Requests\Token;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TokenRequest extends FormRequest
{
	
	public function authorize()
    {
        return true;
    }
	//Rule::unique('categories')->ignore($this->route('id'))
	public function rules()
	{
		return [
			'token'=> ['required', 'string', 'max:200', 'min:20']
		];
	}
	
	public function messages(){
		return [
			'token.required' => 'Поле token должно быть заполнено',
			'token.string' => 'Поле token имеет неправильный формат',
			'token.min' => 'Поле token должно быть не менее 20 символов',
			'token.max' => 'Поле token превышает допустимую длину'
		];
	}
	
	public function  attributes()
	{
		return [
			'token' => 'token'
		];
	}

	protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()->all()], 403)); 
	}
	
}
?>