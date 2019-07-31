<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title'         => $this->faker->sentence,
            'description'   => $this->faker->sentence(4),
            'notes'         => 'Some Notes'
        ];
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $attributes = [
            'notes'         => 'Some Notes',
            'title'         => 'Title Changed',
            'description'   => 'Description Changed'
        ];

        $this->patch($project->path(), $attributes)->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertStatus(200);

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_delete_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->delete($project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();

        //$this->be(factory('App\User')->create());
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $this->withoutExceptionHandling();

        //$this->be(factory('App\User')->create());
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $project->invite(auth()->user());

        $this->get('/projects')
            ->assertSee($project->title);
    }

    /** @test */
    public function an_authenticated_user_cannnot_view_projects_of_others()
    {
        //$this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->actingAs(factory('App\User')->create());

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannnot_update_projects_of_others()
    {
        //$this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->actingAs(factory('App\User')->create());

        $attributes = [
            'notes'         => 'Some Notes',
            'title'         => 'Title Changed',
            'description'   => 'Description Changed'
        ];

        $this->patch($project->path(), $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('projects', $attributes);
    }

    /** @test */
    public function an_authenticated_user_cannnot_delete_projects_of_others()
    {
        //$this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $user = factory('App\User')->create();

        $this->actingAs($user);

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->delete($project->path())->assertStatus(403);


        $this->assertDatabaseHas('projects', $project->only('id'));
    }



    /** @test */
    public function guests_can_not_manage_projects()
    {
        //$this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->post('/projects', $project->toArray())->assertRedirect('/login');
        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path() . '/edit')->assertRedirect('/login');
        $this->delete($project->path())->assertRedirect('/login');

        $this->get($project->path())->assertRedirect('/login');
    }
}
