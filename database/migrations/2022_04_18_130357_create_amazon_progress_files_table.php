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
        Schema::create('amazon_progress_files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('amazon_progress_id');
            $table->text('url');

            $table->index(["amazon_progress_id"], 'fk_file_amazon_progress1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('amazon_progress_id', 'fk_file_amazon_progress1_idx')
                ->references('id')->on('amazon_progress')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_progress_files');
    }
};
