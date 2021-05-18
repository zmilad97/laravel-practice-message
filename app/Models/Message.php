<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = "messages";

    protected $fillable = [
        'sender',
        'receiver',
        'files',
        'title',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
