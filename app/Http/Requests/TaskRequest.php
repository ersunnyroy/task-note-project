<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|in:New,Incomplete,Complete',
            'priority' => 'required|in:High,Medium,Low',
            'notes' => 'array',
            'notes.*.subject' => 'required|string|max:255',
            'notes.*.attachment' => 'nullable|array',
            'notes.*.attachment.*' => 'nullable|file|max:10240',
            'notes.*.note' => 'required|string',
        ];
    }
}
