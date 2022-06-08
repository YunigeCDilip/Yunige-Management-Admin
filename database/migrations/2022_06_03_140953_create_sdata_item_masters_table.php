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
    public $tableName = 'sdata_item_masters';

    /**
     * Run the migrations.
     * @table sdata_item_masters
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_master_id');
            $table->unsignedBigInteger('sdata_id');

            $table->index(["item_master_id"], 'fk_sdata_item_masters_item_masters1_idx');

            $table->index(["sdata_id"], 'fk_sdata_item_masters_sdatas1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('item_master_id', 'fk_sdata_item_masters_item_masters1_idx')
                ->references('id')->on('item_masters')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sdata_id', 'fk_sdata_item_masters_sdatas1_idx')
                ->references('id')->on('sdatas')
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
