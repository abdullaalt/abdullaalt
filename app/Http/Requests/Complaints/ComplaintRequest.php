<?php

namespace App\Http\Requests\Complaints;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ComplaintRequest extends FormRequest
{
	
	public function authorize()
    {
        return true;
    }
	//Rule::unique('categories')->ignore($this->route('id'))
	public function rules()
	{
		return [
			'reason'=> ['required', 'string', 'max:15', 'min:2'],
			'source_id'=> ['required', 'int'],
			'source'=> ['required', 'string', 'max:15'],
			'text'=> ['nullable', 'string', 'max:255', 'min:5']
		];
	}
	
	public function messages(){
		return [
			'reason.required' => 'Поле reason должно быть заполнено',
			'reason.string' => 'Поле reason имеет неправильный формат',
			'reason.min' => 'Поле reason должно быть не менее 4 символов',
			'reason.max' => 'Поле reason превышает допустимую длину'
		];
	}
	
	public function  attributes()
	{
		return [
			'reason' => 'причина'
		];
	}

	protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()->all()], 403)); 
	}
	
}
?>