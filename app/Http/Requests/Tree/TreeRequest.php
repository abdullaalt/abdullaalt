<?php

namespace App\Http\Requests\Tree;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TreeRequest extends FormRequest
{
	
	public function authorize()
    {
        return true;
    }
	//Rule::unique('categories')->ignore($this->route('id'))
	public function rules()
	{
		return [
			'fio' => 'required|string|min:4|max:80',
			'source_id' => 'nullable|int',
			'spouce_id' => 'nullable|int',
			'f_id' => 'nullable|int',
			'm_id' => 'nullable|int',
			'born' => 'nullable|date',
		];
	}
	
	public function messages(){
		return [
			'fio.required' => 'Поле fio должно быть заполнено',
			'fio.string' => 'Поле fio имеет неправильный формат',
			'fio.min' => 'Поле fio должно быть не менее 10 символов',
			'fio.max' => 'Поле fio превышает допустимую длину'
		];
	}
	
	public function  attributes()
	{
		return [
			'title' => 'ФИО'
		];
	}

	protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors()->all(), 403)); 
	}
	
}
?>