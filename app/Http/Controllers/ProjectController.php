<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function getProjects(Request $request)
    {
        $credentials = $request->validate([
            'token'  => 'required|string',
        ]);
    
        $user = User::where('session_token', $credentials['token'])->first();

        if($user)
        {
            $projects = Project::where('id_user', $user->id_user)->get();

            $project_object = [
                'todo' => [

                ],
                'kanban' => [

                ],
            ];

            foreach($projects as $project)
            {
                switch($project['project_type'])
                {
                    case "T":
                        $type = "todo";
                    break;

                    case "K":
                        $type = "kanban";
                    break;
                }

                $project_object[$type][$project['title_project']] = [
                    'id'        => $project['id_project'],
                    'icon_name' => $project['icon_project'],
                    'type'      => $type
                ];
            }

            if($projects)
            {
                return response()->json([
                    'projects' => $project_object,
                    'success'  => true,
                    'message'  => "Projects exists",
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "Invalid token",
            ]);
        }
    }

    public function addProject(Request $request)
    { 
        $credentials = $request->validate([
            'title'     => 'required|string',
            'icon_name' => 'required|string',
            'token'     => 'required|string',
            'type'      => 'required|string',
            'days'      => 'required|int',
        ]);
    
        $user = User::where('session_token', $credentials['token'])->first();

        if($user)
        {
            $project = new Project;
            
            $project->title_project = $credentials['title'];
            $project->color_project = null;
            $project->icon_project  = $credentials['icon_name'];
            $project->project_type  = $credentials['type'] == 'todo' ? 'T' : 'K';
            $project->create_date   = date('Y-m-d H:i:s');
            $project->id_user       = $user->id_user;
            $project->days_project  = $credentials['days'];

            $project->save();

            return response()->json([
                'success' => true,
                'message' => "Project added",
            ]);
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "Invalid token",
            ]);
        }
    }

    public function editProject(Request $request)
    {
        
    }

    public function removeProject(Request $request)
    {
        
    }
}
