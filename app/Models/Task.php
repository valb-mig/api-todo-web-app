<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasApiTokens;

    protected $table      = 'todo_tasks';
    protected $primaryKey = 'task_id';
    public    $timestamps = true;
}