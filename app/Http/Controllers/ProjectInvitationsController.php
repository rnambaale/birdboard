<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectInvitationRequest;
use App\Project;
use App\User;


class ProjectInvitationsController extends Controller
{
    public function store(ProjectInvitationRequest $request, Project $project)
    {
        //$this->authorize('update', $project);

        // $request->validate(
        //     [
        //         'email' => ['required','exists:users,email']
        //     ],
        //     [
        //         'email.exists' => 'The user you are inviting must have a Birdboard account.'
        //     ]
        // );        

        $invitedUser = User::where(['email' => $request['email']])->first();

        $project->invite($invitedUser);

        return redirect($project->path());
    }
}
