<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_id');
            $table->string('host_id');
            $table->string('host_email');
            $table->string('topic');
            $table->string('type')->nullable();
            $table->string('start_time');
            $table->string('duration');
            $table->string('timezone');
            $table->string('agenda')->nullable();
            $table->string('password')->nullable();
            $table->text('start_url')->nullable();

            $table->string('join_url');

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
        Schema::dropIfExists('zoom_meetings');
    }
};
