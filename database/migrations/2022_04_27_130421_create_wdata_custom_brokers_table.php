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
    public $tableName = 'wdata_custom_brokers';

    /**
     * Run the migrations.
     * @table wdata_custom_broker
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wdata_id');
            $table->unsignedBigInteger('custom_broker_id');

            $table->index(["wdata_id"], 'fk_wdata_custom_brokers_wdata1_idx');

            $table->index(["custom_broker_id"], 'fk_wdata_custom_brokers_custom_brokers1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('wdata_id', 'fk_wdata_custom_brokers_wdata1_idx')
                ->references('id')->on('wdatas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('custom_broker_id', 'fk_wdata_custom_brokers_custom_brokers1_idx')
                ->references('id')->on('custom_brokers')
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
