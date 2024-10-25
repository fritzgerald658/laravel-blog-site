<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    use HasFactory;

    protected $table = "blog_tables";

    protected $fillable = [
        'user_id',
        'likes',
        'blog_title',
        'blog_description',
        'is_private'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
