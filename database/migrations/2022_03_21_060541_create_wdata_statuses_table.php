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
    public $tableName = 'wdata_statuses';

    /**
     * Run the migrations.
     * @table wdata_statuses
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('ja_name', 155)->nullable();
            $table->string('en_name', 155)->nullable();
            $table->string('color', 50)->nullable();
            $table->unique(["ja_name"], 'ja_name_UNIQUE');
            $table->unique(["en_name"], 'en_name_UNIQUE');
            $table->softDeletes();
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
        Schema::dropIfExists($this->tableName);
    }
};
