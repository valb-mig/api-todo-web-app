<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function getProjects(Request $request)
    {
        $token = $request->header('Authorization');

        if ( $user = User::where('remember_token', $token)->first() )
        {
            $projects = Project::where('user_id', $user->user_id)->get();

            $project_object = [
                
                'todo' => [

                ],
                'kanban' => [

                ],
            ];

            foreach( $projects as $project )
            {
                switch( $project['project_type'] )
                {
                    case "T":
                        $type = "todo";
                    break;

                    case "K":
                        $type = "kanban";
                    break;
                }

                $tasks = Task::where('user_id', $user->user_id)
                             ->where('project_id', $project->project_id)
                             ->where('task_type', $project->project_type)
                             ->where('task_status','A')
                             ->get();

                $project_object[$type][$project['project_id']] = [
                
                    'project_title' =>  $project['project_title'],
                    'project_icon'  =>  $project['project_icon'],
                    'project_type'  =>  $type,
                    'project_tasks' =>  $tasks
                ];
            }

            if ($projects)
            {
                return response()->json([
                    'success'  => true,
                    'projects' => $project_object
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "Invalid token"
            ]);
        }
    }

    public function addProject(Request $request)
    { 
        $token = $request->header('Authorization');

        $credentials = $request->validate([
            'project_title' => 'required|string',
            'project_icon'  => 'required|string',
            'project_type'  => 'required|string',
            'project_days'  => 'required|int'
        ]);

        if ( $user = User::where('remember_token', $token)->first() )
        {
            $project = new Project;
            
            $project->project_title = $credentials['project_title'];
            $project->project_color = null;
            $project->project_icon  = $credentials['project_icon'];
            $project->project_type  = $credentials['project_type'] == "todo" ? "T" : "K";
            $project->project_days  = $credentials['project_days'];
            $project->created_at    = date('Y-m-d H:i:s');
            $project->user_id       = $user->user_id;
            $project->project_days  = $credentials['project_days'];

            $project->save();

            return response()->json([
                'success' => true,
                'message' => "Project added"
            ]);
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "Invalid token"
            ]);
        }
    }

    public function editProject(Request $request)
    {
        /* [Todo]: Edit project code */
    }

    public function removeProject(Request $request)
    {
        /* [Todo]: Remove project code */
    }
}
