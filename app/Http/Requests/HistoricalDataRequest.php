<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricalDataRequest extends FormRequest
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
            'symbol' => 'required',
            'email'         => 'required|email',
            'start_date'    => 'required|date|date_format:Y-m-d|before_or_equal:today|before_or_equal:end_date',
            'end_date'      => 'required|date|date_format:Y-m-d|before_or_equal:today|after_or_equal:start_date'
        ];
    }
}
