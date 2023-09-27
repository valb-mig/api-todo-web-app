<?php

namespace App\Http\Controllers\Api;

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
        $token = $request->header('Authorization');
        $user  = User::where('remember_token', $token)->first();

        $credentials = $request->validate([ 
            'project_id' => 'required|int' 
        ]);
    
        $project = Project::where('project_id', $credentials['project_id'])
                        ->where('user_id', $user->user_id)
                        ->first();

        if($project) 
        {
            $tasks = Task::where('user_id',      $user->user_id)
                            ->where('project_id',$project->project_id)
                            ->where('task_type', $project->project_type)
                            ->where('task_status','A')
                            ->get();

            return response()->json([
                'success' => true,
                'tasks'   => $tasks
            ], 200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => "Project doesn't exist"
            ], 404);
        }
    }

    public function addTask(Request $request)
    {
        $token = $request->header('Authorization');
        $user  = User::where('remember_token', $token)->first();

        $credentials = $request->validate([
            'project_id' => 'required|int',
            'task_title' => 'required|string',
            'task_desc'  => 'required|string'
        ]);  

        $project = Project::where('project_id', $credentials['project_id'])
                        ->where('user_id', $user->user_id)
                        ->first();
        if ($project) 
        {
            $task = new Task();

            $task->task_title  = $credentials['task_title'];
            $task->task_desc   = $credentials['task_desc'];
            $task->task_type   = $project->project_type;
            $task->project_id  = $project->project_id;
            $task->user_id     = $user->user_id;
            $task->task_status = "A";
            $task->updated_at  = now();
            $task->created_at  = now();

            $task->save();

            return response()->json([
                
                'success' => true,
                'message' => "Task added successfully",
                'task'    => $task
            ], 200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => "Project doesn't exist"
            ], 404);
        }
    }

    public function editTask(Request $request) 
    {
        $token = $request->header('Authorization');
        $user  = User::where('remember_token', $token)->first();

        $credentials = $request->validate([
            'project_id' => 'required|int',
            'task_id'    => 'required|int',
            'action'     => 'required|string'
        ]); 

        $project = Project::where('project_id', $credentials['project_id'])
                        ->where('user_id', $user->user_id)
                        ->first();
        if ($project) 
        {
            $task = Task::where('project_id', $credentials['project_id'])
                        ->where('user_id',    $user->user_id)
                        ->where('task_id',    $credentials['task_id'])
                        ->first();

            switch($credentials['action']) {

                case 'done':
                    $task->task_done = "Y";
                break;

                case 'not-done':
                    $task->task_done = "N";
                break;
            }

            $task->updated_at = now();

            $task->save();

            return response()->json([
                'success' => true,
                'message' => "Task edited successfully"
            ], 200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => "Project doesn't exist"
            ], 404);
        }
    }

    public function removeTask(Request $request) 
    {
        $token = $request->header('Authorization');
        $user  = User::where('remember_token', $token)->first();

        $credentials = $request->validate([
            'project_id' => 'required|int',
            'task_id'    => 'required|int'
        ]); 

        $project = Project::where('project_id', $credentials['project_id'])
                        ->where('user_id', $user->user_id)
                        ->first();
        if ($project) 
        {
            $task = Task::where('project_id', $credentials['project_id'])
                        ->where('user_id', $user->user_id)
                        ->where('task_id', $credentials['task_id'])
                        ->first();

            $task->task_status = "I";
            $task->updated_at  = now();

            $task->save();

            return response()->json([
                'success' => true,
                'message' => "Task removed successfully"
            ], 200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => "Project doesn't exist"
            ], 404);
        }
    }
}
