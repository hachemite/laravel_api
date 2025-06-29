<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    protected $guarded = [];

    use HasFactory;
    protected $fillable = ['title', 'content', 'user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
