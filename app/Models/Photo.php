<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['user_id', 'image_path', 'caption'];

public function user()
{
    return $this->belongsTo(User::class);
}
public function likes()
{
    return $this->hasMany(PhotoLike::class);
}

public function isLikedByUser($userId)
{
    return $this->likes()->where('user_id', $userId)->exists();
}
public function comments()
{
    return $this->hasMany(PhotoComment::class);
}



    //
}
