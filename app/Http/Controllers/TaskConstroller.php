<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class TaskConstroller extends Controller
{
    public function getTasks(Request $request)
    {
        $credentials = $request->validate([
            'token'      => 'required|string',
            'id_project' => 'required|int',
        ]);
    
        $user = User::where('session_token', $credentials['token'])->first();

        if($user)
        {
            $project = Project::where('id_project', $credentials['id_project'])
                              ->where('id_user', $user->id_user)
                              ->first();

            if($project) 
            {
                $tasks = Task::where('id_user',$user->id_user)
                             ->where('id_project',$project->id_project)
                             ->where('task_type',$project->project_type)
                             ->where('task_status','A')
                             ->get();

                return response()->json([
                    'success' => true,
                    'tasks'   => $tasks
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Project doesn't exist",
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User doesn't exists",
            ]);
        }
    }

    public function addTask(Request $request)
    {
        $credentials = $request->validate([
            'token'      => 'required|string',
            'id_project' => 'required|int',
            'task_title' => 'required|string',
            'task_desc'  => 'required|string',
        ]);  

        $user = User::where('session_token', $credentials['token'])->first();

        if($user)
        {
            $project = Project::where('id_project', $credentials['id_project'])
                              ->where('id_user', $user->id_user)
                              ->first();
            if($project) 
            {
                $task = new Task();

                $task->task_title  = $credentials['task_title'];
                $task->task_desc   = $credentials['task_desc'];
                $task->task_type   = $project->project_type;
                $task->id_project  = $project->id_project;
                $task->id_user     = $user->id_user;
                $task->task_status = "A";
                $task->date_status_task = date('Y-m-d H:i:s');
                $task->create_date      = date('Y-m-d H:i:s');

                $task->save();

                return response()->json([
                    'success' => true,
                    'message' => "Task added successfully",
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Project doesn't exist",
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User doesn't exists",
            ]);
        }
    }
}
