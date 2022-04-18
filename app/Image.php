<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image', 'alt'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
