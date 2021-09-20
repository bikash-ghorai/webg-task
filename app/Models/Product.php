<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'add_by_user'];

    public function userInfo()
    {
        return $this->hasOne(User::class, 'user_id', 'add_by_user');
    }
}
