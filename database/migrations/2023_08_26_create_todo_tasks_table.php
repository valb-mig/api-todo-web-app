<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todo_tasks', function (Blueprint $table) {
            
            $table->increments('task_id');
            $table->integer('user_id');
            $table->integer('project_id');
            $table->string('task_title');
            $table->string('task_desc');
            $table->string('task_type')->default('T')->enum(['T', 'K']);
            $table->string('task_done')->default('N')->enum(['Y', 'N']);
            $table->string('task_status')->default('A')->enum(['A', 'I']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todo_tasks');
    }
};
