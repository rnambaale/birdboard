<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Database\Eloquent\Collection;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_projects()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function has_accessible_projects()
    {
        $john = factory(User::class)->create();

        $johnProject = factory('App\Project')->create(['owner_id' => $john->id]);

        $this->assertCount(1, $john->accessibleProjects());

        $sally = factory(User::class)->create();
        $nick = factory(User::class)->create();

        $sallyProject = factory('App\Project')->create(['owner_id' => $sally->id]);

        $sallyProject->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());
        $this->assertCount(1, $nick->accessibleProjects());

        $sallyProject->invite($john);
        $this->assertCount(2, $john->accessibleProjects());
    }
}
