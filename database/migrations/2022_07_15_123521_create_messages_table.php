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
    public $tableName = 'messages';

    /**
     * Run the migrations.
     * @table messages
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('subject');
            $table->longText('message')->nullable();
            $table->unsignedBigInteger('sender_id');
            $table->tinyInteger('draft')->default('0');
            $table->tinyInteger('sent')->default('0');

            $table->index(["designation_id"], 'fk_designations_messages1_idx');
            $table->index(["sender_id"], 'fk_users_messages1_idx');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('designation_id', 'fk_designations_messages1_idx')
                ->references('id')->on('designations')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sender_id', 'fk_users_messages1_idx')
                ->references('id')->on('users')
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
