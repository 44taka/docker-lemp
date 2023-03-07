<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class BookRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:200',
            'author_id' => 'required|integer|min:0',
        ];
    }
}
