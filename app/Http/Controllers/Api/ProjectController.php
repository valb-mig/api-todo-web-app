<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function getProjects(Request $request)
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
            $tasks = Task::where('user_id', $user->user_id)
                        ->where('project_id', $project->project_id)
                        ->where('task_type', $project->project_type)
                        ->where('task_status','A')
                        ->get();

            $project_object[$project['project_type']][$project['project_id']] = [
            
                'project_title' =>  $project['project_title'],
                'project_icon'  =>  $project['project_icon'],
                'project_type'  =>  $project['project_type'],
                'project_tasks' =>  $tasks
            ];
        }

        if ($projects)
        {
            return response()->json([
                'success'  => true,
                'projects' => $project_object
            ], 200);
        }
    }

    public function addProject(Request $request)
    { 
        $token = $request->header('Authorization');
        $user  = User::where('remember_token', $token)->first();

        $credentials = $request->validate([
            'project_title' => 'required|string',
            'project_icon'  => 'required|string',
            'project_type'  => 'required|string',
            'project_days'  => 'required|int'
        ]);

        $project = new Project;
        
        $project->project_title = $credentials['project_title'];
        $project->project_color = null;
        $project->project_icon  = $credentials['project_icon'];
        $project->project_type  = $credentials['project_type'] == "todo" ? "T" : "K";
        $project->project_days  = $credentials['project_days'];
        $project->created_at    = now();
        $project->user_id       = $user->user_id;
        $project->project_days  = $credentials['project_days'];

        $project->save();

        return response()->json([
            'success' => true,
            'message' => "Project added"
        ], 200);
    }

    public function editProject(Request $request)
    {
        $token = $request->header('Authorization');
        $user  = User::where('remember_token', $token)->first();

        /* [Todo]: Edit project code */
    }

    public function removeProject(Request $request)
    {
        $token = $request->header('Authorization');
        $user  = User::where('remember_token', $token)->first();

        /* [Todo]: Remove project code */
    }
}
