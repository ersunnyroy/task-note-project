<?php

// app/Http/Requests/NoteRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'attachment' => 'file|mimes:txt,pdf,docx', // Add allowed file types
            'note' => 'required|string',
        ];
    }
}