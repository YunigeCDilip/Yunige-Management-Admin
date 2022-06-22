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
    public $tableName = 'item_master_stores';

    /**
     * Run the migrations.
     * @table item_master_stores
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_master_id');
            $table->bigInteger('quantity')->default(0);

            $table->index(["item_master_id"], 'fk_item_masters_item_ms1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('item_master_id', 'fk_item_masters_item_ms1_idx')
                ->references('id')->on('item_masters')
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
