<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todo_projects', function (Blueprint $table) {
            
            $table->increments('project_id');
            $table->integer('user_id');
            $table->integer('task_id');
            $table->string('project_title');
            $table->string('project_icon');
            $table->string('project_days');
            $table->string('project_color')->nullable();
            $table->string('project_type')->default('T')->enum(['T', 'K']);
            $table->string('project_status')->default('A')->enum(['A', 'I']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todo_projects');
    }
};