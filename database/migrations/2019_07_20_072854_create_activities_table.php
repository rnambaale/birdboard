<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unSignedInteger('user_id');
            $table->unSignedInteger('project_id');
            $table->nullableMorphs('subject');
            // $table->unSignedInteger('subject_id'); // 9
            // $table->string('subject_type'); // App\Task
            $table->string('description');
            $table->text('changes')->nullable();
            $table->timestamps();

        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
