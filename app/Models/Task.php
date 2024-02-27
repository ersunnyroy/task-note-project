<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['subject', 'description', 'start_date', 'due_date', 'status', 'priority', 'user_id'];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
