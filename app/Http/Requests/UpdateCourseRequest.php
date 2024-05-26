<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('super_create');;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => 'string',
            'subject' => 'string',
            'subjectCode' => 'string',
            'room_id' => 'string',
            'description' => 'string',
            'status' => 'string',
            'unit' => 'string',
            'day' => 'string',
            'time_start' => 'string',
            'time_end' => 'string',
            'block' => 'string',
        ];
    }
}
