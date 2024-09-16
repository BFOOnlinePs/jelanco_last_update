<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNoteBookModel extends Model
{
    use HasFactory;

    protected $table = 'user_note_book';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
