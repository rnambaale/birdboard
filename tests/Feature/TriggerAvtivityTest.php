<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function creating_a_project()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created_project', $project->activity[0]->description);

        $last_activity = $project->activity->last();

        $this->assertNull($last_activity->changes);
    }

    /** @test */
    public function updating_a_project()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();

        $originalTitle = $project->title;

        $project->update([
            'title' => 'Updated'
        ]);

        $project->refresh();

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated_project', $project->activity->last()->description);


        $last_activity = $project->activity->last();

        $expected = [
            'before'    => ['title' => $originalTitle],
            'after'     => ['title' => 'Updated']
        ];

        $this->assertEquals($expected, $last_activity->changes);

    }

    /** @test */
    public function creating_a_project_task()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();

        $project->addTask('Some Task');

        $this->assertCount(2, $project->activity);


        $last_activity = $project->activity->last();
        $this->assertEquals('created_task', $last_activity->description);
        $this->assertInstanceOf(Task::class, $last_activity->subject);
        $this->assertEquals('Some Task', $last_activity->subject->body);
        
        // tap($project->activity->last(), function ($activity) {
        //     $this->assertEquals('created_task', $activity->description);
        //     $this->assertInstanceOf(Task::class, $activity->subject);
        //     $this->assertEquals('Some Task', $activity->subject->body);
        // });
    }

    /** @test */
    public function completing_a_project_task()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->addTask('Some Task');


        $this->patch($project->tasks[0]->path(), [
            'body'      => 'updated',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);

        $last_activity = $project->activity->last();
        $this->assertEquals('completed_task', $last_activity->description);
        $this->assertInstanceOf(Task::class, $last_activity->subject);
        $this->assertEquals('updated', $last_activity->subject->body);
    }

    /** @test */
    public function incompleting_a_project_task()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->addTask('Some Task');

        $this->patch($project->tasks[0]->path(), [
            'body'      => 'foobar',
            'completed' => true
        ]);

        //dd($project->activity->toArray());

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body'      => 'foobar',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    /** @test */
    public function deleting_a_project_task()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->addTask('Some Task');

        $this->delete($project->tasks[0]->path());

        //dd($project->activity->toArray());

        $this->assertCount(3, $project->activity);
        $this->assertEquals('deleted_task', $project->activity->last()->description);
    }
}
