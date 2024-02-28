<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['subject', 'attachment', 'note'];
    protected $casts = [
        'attachments' => 'array',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
