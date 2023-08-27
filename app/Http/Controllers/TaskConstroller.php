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
        $token = $request->header('Authorization');

        $credentials = $request->validate([
            'project_id' => 'required|int',
        ]);
    
        if ( $user = User::where('session_token', $token)->first() )
        {
            $project = Project::where('project_id', $credentials['project_id'])
                              ->where('user_id', $user->user_id)
                              ->first();

            if($project) 
            {
                $tasks = Task::where('user_id',$user->id_user)
                             ->where('project_id',$project->id_project)
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
                    'message' => "Project doesn't exist"
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User doesn't exists"
            ]);
        }
    }

    public function addTask(Request $request)
    {
        $token = $request->header('Authorization');

        $credentials = $request->validate([
            'project_id' => 'required|int',
            'task_title' => 'required|string',
            'task_desc'  => 'required|string'
        ]);  

        if ( $user = User::where('session_token', $token)->first() )
        {
            $project = Project::where('project_id', $credentials['id_project'])
                              ->where('user_id', $user->id_user)
                              ->first();
            if ($project) 
            {
                $task = new Task();

                $task->task_title  = $credentials['task_title'];
                $task->task_desc   = $credentials['task_desc'];
                $task->task_color  = "default";
                $task->task_type   = $project->project_type;
                $task->project_id  = $project->project_id;
                $task->user_id     = $user->user_id;
                $task->task_status = "A";
                $task->updated_at  = date('Y-m-d H:i:s');
                $task->created_at  = date('Y-m-d H:i:s');

                $task->save();

                return response()->json([
                 
                    'success' => true,
                    'message' => "Task added successfully",
                    'task'    => $task
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Project doesn't exist"
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User doesn't exists"
            ]);
        }
    }

    public function editTask(Request $request) 
    {
        $token = $request->header('Authorization');

        $credentials = $request->validate([
            'project_id' => 'required|int',
            'task_id'    => 'required|int',
            'action'     => 'required|string'
        ]); 

        if ( $user = User::where('remember_token', $token)->first() )
        {
            $project = Project::where('project_id', $credentials['project_id'])
                              ->where('user_id', $user->user_id)
                              ->first();
            if ( $project ) 
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

                $task->updated_at = date('Y-m-d H:i:s');

                $task->save();

                return response()->json([
                    'success' => true,
                    'message' => "Task edited successfully"
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Project doesn't exist"
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User doesn't exists"
            ]);
        }
    }

    public function removeTask(Request $request) 
    {
        $token = $request->header('Authorization');

        $credentials = $request->validate([
            'project_id' => 'required|int',
            'task_id'    => 'required|int'
        ]); 

        if ( $user = User::where('remember_token', $token)->first() )
        {
            $project = Project::where('project_id', $credentials['project_id'])
                              ->where('user_id', $user->user_id)
                              ->first();
            if ( $project ) 
            {
                $task = Task::where('project_id', $credentials['project_id'])
                            ->where('user_id', $user->id_ususer_ider)
                            ->where('task_id', $credentials['task_id'])
                            ->first();

                $task->task_status = "I";
                $task->updated_at  = date('Y-m-d H:i:s');

                $task->save();

                return response()->json([
                    'success' => true,
                    'message' => "Task removed successfully"
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Project doesn't exist"
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User doesn't exists"
            ]);
        }
    }
}
