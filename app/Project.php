<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id'       => $this->owner_id,
            'description'   => $description,
            'changes'       => $this->getAtivityChanges($description)
        ]);
    }

    public function getAtivityChanges($description)
    {
        if($description !== 'updated_project'){
            return null;
        }

        return [
            'before'    => array_except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
            'after'     => array_except(array_diff($this->getAttributes(), $this->old), 'updated_at')
        ];
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }


    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }
}
