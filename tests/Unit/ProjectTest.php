<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_knows_its_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/'.$project->id, $project->path());
        
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        $this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $task = $project->addTask('Test Task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function it_can_invite_a_user()
    {
        $this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $project->invite($invitedUser = factory(User::class)->create());

        $this->assertTrue($project->members->contains($invitedUser));
    }


}
