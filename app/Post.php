<?php

namespace App;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Hekmatinasser\Verta\Facades\Verta;

class Post extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['images'];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'user_id', 'description', 'body', 'is_active'
    ];

    public function PersianCreatedAt($format = "%d %B %Y")
    {
        return Verta::instance($this->created_at)->format($format);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
