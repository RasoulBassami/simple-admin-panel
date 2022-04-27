<?php

namespace App\Models;

use App\Traits\PersianDate;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, CascadeSoftDeletes, PersianDate;

    protected $cascadeDeletes = ['images'];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'user_id', 'description', 'body', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function format()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->user->name,
            'created_at' => $this->PersianCreatedAt(),
            'status' => $this->is_active,
        ];
    }
}
