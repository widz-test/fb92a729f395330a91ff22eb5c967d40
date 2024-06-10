<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class MailSenderRequest extends Request
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
            'sender' => ['required', 'string', 'email'],
            'receiver' => ['required', 'string', 'email'],
            'title' => ['required', 'string'],
            'message' => ['required', 'string']
        ];
    }
}
