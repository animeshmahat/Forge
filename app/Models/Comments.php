<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'parent_id', 'name', 'email', 'message'];

    public function post()
    {
        return $this->belongsTo(Posts::class, 'post_id');
    }
    public function parent()
    {
        return $this->belongsTo(Comments::class, 'parent_id');
    }
    public function replies()
    {
        return $this->hasMany(Comments::class, 'parent_id');
    }
}
