<?php

namespace App\Http\Requests\Wall;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class WallRequest extends FormRequest
{
	
	public function authorize()
    {
        return true;
    }
	//Rule::unique('categories')->ignore($this->route('id'))
	public function rules()
	{
		return [
            'media' => 'nullable|array',
			'content' => 'nullable|string',
			'votes' => 'nullable|array',
			'marked_users' => 'nullable|array',
			'proportions' => 'nullable|array',
			'permissions' => 'nullable|array',
			'post_id' => 'nullable|int',
			'recommendate' => 'nullable|int'
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
			'media' => 'Контент',
			'content' => 'Текст',
			'votes' => 'Голосавание',
			'marked_users' => 'Отметки',
			'proportions' => 'Пропорции',
			'permissions' => 'Видимость',
			'post_id' => 'Номер поста'
		];
	}

	protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors()->all(), 403)); 
	}
	
}
?>