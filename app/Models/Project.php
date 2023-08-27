<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasApiTokens;

    protected $table      = 'todo_projects';
    protected $primaryKey = 'project_id';
    public    $timestamps = true;
}