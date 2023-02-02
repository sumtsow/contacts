<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
        'value' => 'string|max:255|unique:contact,value',
        'enabled' => 'filled',
        'subscriber_id' => 'integer|exists:subscriber,id',
				'type_id' => 'integer|exists:type,id',
      ];
    }
}
