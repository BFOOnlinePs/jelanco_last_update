<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessageModel extends Model
{
    use HasFactory;

    protected $table = 'chat_message';
}
