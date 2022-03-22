<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'client_amazon_progress';

    /**
     * Run the migrations.
     * @table client_amazon_progress
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('amazon_progress_id');

            $table->index(["amazon_progress_id"], 'fk_client_amazon_progress_amazon_progress1_idx');

            $table->index(["client_id"], 'fk_client_amazon_progress_clients1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('amazon_progress_id', 'fk_client_amazon_progress_amazon_progress1_idx')
                ->references('id')->on('amazon_progress')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('client_id', 'fk_client_amazon_progress_clients1_idx')
                ->references('id')->on('clients')
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
        Schema::dropIfExists($this->tableName);
    }
};
