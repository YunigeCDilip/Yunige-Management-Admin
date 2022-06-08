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
    public $tableName = 'user_designations';

    /**
     * Run the migrations.
     * @table user_designations
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('designation_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index(["user_id"], 'fk_user_designations_users1_idx');

            $table->index(["designation_id"], 'fk_user_designations_designations1_idx');

            $table->foreign('user_id', 'fk_user_designations_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('designation_id', 'fk_user_designations_designations1_idx')
                ->references('id')->on('designations')
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
