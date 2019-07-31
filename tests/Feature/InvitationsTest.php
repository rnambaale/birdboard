<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function nonowners_project_cannot_invite_a_user()
    {
        //$this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->actingAs($user);

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/invitations', [
            'email' => 'someemail@email.com'
        ])->assertStatus(403);


        $project->invite($user);

        $this->post($project->path() . '/invitations', [])->assertStatus(403);
    }



    /** @test */
    public function a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $userToInvite = factory('App\User')->create();

        $this->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function invited_email_must_be_associated_with_a_birdboard_account()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/invitations', [
            'email' => 'notauser@email.com'
        ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Birdboard account.'
            ], null, 'invitations');
    }

    /** @test */
    public function invited_users_may_update_project_details()
    {
        $project = factory('App\Project')->create();
        $project->invite($newUser = factory('App\User')->create());

        $this->actingAs($newUser);

        $this->post($project->path() . '/tasks', $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
