<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Item extends Model
{
    protected $fillable = ['name', 'description', 'category_id', 'user_id', 'image_path', 'premium'];

    use HasFactory;

    public function categories()
{
    return $this->belongsToMany(Category::class);
    
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

}

?>