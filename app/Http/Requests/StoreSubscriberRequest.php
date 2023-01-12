<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
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
				'group_id' => 'integer|exists:group,id',
        'firstname' => 'string|max:255',
				'lastname' => 'string|max:255|nullable',
        'enabled' => 'filled',
      ];
    }
}
