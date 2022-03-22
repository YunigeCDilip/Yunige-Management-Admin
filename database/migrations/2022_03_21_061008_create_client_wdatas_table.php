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
    public $tableName = 'client_wdatas';

    /**
     * Run the migrations.
     * @table client_wdata
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('wdata_id');

            $table->index(["client_id"], 'fk_client_wdata_clients1_idx');

            $table->index(["wdata_id"], 'fk_client_wdata_wdatas1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('client_id', 'fk_client_wdata_clients1_idx')
                ->references('id')->on('clients')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('wdata_id', 'fk_client_wdata_wdatas1_idx')
                ->references('id')->on('wdatas')
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
