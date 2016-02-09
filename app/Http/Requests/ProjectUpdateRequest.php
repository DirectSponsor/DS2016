<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectUpdateRequest extends Request
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
            'name' => 'required|min:3|unique:projects',
            'max_recipients' => 'required|numeric',
            'max_sponsors_per_recipient' => 'required|numeric',
            'max_recipients_per_sponsor' => 'required|numeric',
            'currency' => 'required',
            'amount' => 'required|numeric',
            'euro_amount' => 'required|numeric',
            'recipient_amount_local_currency' => 'required|numeric'
        ];
    }
}
