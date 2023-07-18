<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Project extends Model
{
    use HasApiTokens;

    protected $table      = 'todo_projects_tb';
    protected $primaryKey = 'id_project';
    public    $timestamps = false;
    // protected $fillable   = ['username', 'password'];
}