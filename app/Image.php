<?php

namespace App;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'image', 'alt'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
