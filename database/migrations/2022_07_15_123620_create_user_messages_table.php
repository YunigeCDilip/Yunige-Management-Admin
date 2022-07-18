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
    public $tableName = 'user_messages';

    /**
     * Run the migrations.
     * @table user_messages
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('message_id');
            $table->unsignedBigInteger('receiver_id');
            $table->tinyInteger('read')->default('0');

            $table->index(["message_id"], 'fk_m_user_messages1_idx');
            $table->index(["receiver_id"], 'fk_users_user_messages1_idx');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('message_id', 'fk_m_user_messages1_idx')
                ->references('id')->on('messages')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('receiver_id', 'fk_users_user_messages1_idx')
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
