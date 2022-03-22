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
    public $tableName = 'bogyo_tests';

    /**
     * Run the migrations.
     * @table bogyo_tests
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('bogyo_warehouse_id');

            $table->index(["client_id"], 'fk_bogyo_tests_clients1_idx');

            $table->index(["bogyo_warehouse_id"], 'fk_bogyo_tests_bogyo_warehouses1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('client_id', 'fk_bogyo_tests_clients1_idx')
                ->references('id')->on('clients')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('bogyo_warehouse_id', 'fk_bogyo_tests_bogyo_warehouses1_idx')
                ->references('id')->on('bogyo_warehouses')
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
