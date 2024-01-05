<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventsAddRequest extends FormRequest
{
	
	public function authorize()
    {
        return true;
    }
	//Rule::unique('categories')->ignore($this->route('id'))
	public function rules()
	{
		return [
			'action'=> ['required', 'string', 'max:15', 'min:4'],
			'address'=> ['nullable', 'string', 'max:70'],
			'date'=> ['required', 'string', 'max:15'],
			'info'=> ['nullable', 'string', 'max:255', 'min:5'],
			'details'=> ['nullable', 'string', 'max:1000', 'min:5'],
			//'email'=> ['nullable', 'email', 'string', 'max:30'],
			'phone'=> ['nullable', 'string', 'max:25']
		];
	}
	
	public function messages(){
		return [
			'action.required' => 'Поле action должно быть заполнено',
			'action.string' => 'Поле action имеет неправильный формат',
			'action.min' => 'Поле action должно быть не менее 4 символов',
			'action.max' => 'Поле action превышает допустимую длину'
		];
	}
	
	public function  attributes()
	{
		return [
			'action' => 'тип события'
		];
	}

	protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()->all()], 403)); 
	}
	
}
?>