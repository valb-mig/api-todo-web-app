<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class User extends Model
{
    use HasApiTokens;

    protected $table      = 'todo_users_tb';
    protected $primaryKey = 'id_user';
    public    $timestamps = true;
    protected $fillable   = ['username', 'password'];
}