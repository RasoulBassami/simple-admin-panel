<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'path', 'name'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
