<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
        
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $task_attributes = ['body' => $this->faker->sentence];

        $this->post($project->path().'/tasks', $task_attributes);

        $this->get($project->path())->assertSee($task_attributes['body']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        //$this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
        
        //project created by someone who is not the signedin user
        $project = factory('App\Project')->create();

        $task_attributes = ['body' => $this->faker->sentence];

        $this->post($project->path().'/tasks', $task_attributes)->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $task_attributes);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {
        //$this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
        
        //project created by someone who is not the signedin user
        $project = factory('App\Project')->create();

        $task = $project->addTask($this->faker->sentence);

        $task_attributes = ['body' => 'change'];

        $this->patch($task->path(), $task_attributes)->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $task_attributes);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
        
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $task = $project->addTask($this->faker->sentence);

        $task_attributes = [
            'body' => 'changed',
            'completed' => TRUE
        ];

        $this->patch($task->path(), $task_attributes);

        $this->assertDatabaseHas('tasks', $task_attributes);

    }
}
