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
    public $tableName = 'message_details';

    /**
     * Run the migrations.
     * @table message_details
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('message_id');
            $table->longText('message')->nullable();
            $table->unsignedBigInteger('sender_id');

            $table->index(["message_id"], 'fk_m_message_details1_idx');
            $table->index(["sender_id"], 'fk_users_message_details1_idx');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('message_id', 'fk_m_message_details1_idx')
                ->references('id')->on('messages')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sender_id', 'fk_users_message_details1_idx')
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
