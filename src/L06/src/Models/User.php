<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    // BEGIN (write your solution here)
    protected $fillable = ['email', 'first_name', 'last_name'];
    // END
}
