<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasApiTokens;

    protected $table      = 'todo_tasks_tb';
    protected $primaryKey = 'id_task';
    public    $timestamps = false;
}