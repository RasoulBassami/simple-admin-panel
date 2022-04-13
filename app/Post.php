<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'user_id', 'description', 'body', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
