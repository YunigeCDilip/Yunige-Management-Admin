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
    public $tableName = 'client_items';

    /**
     * Run the migrations.
     * @table client_items
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('item_master_id');

            $table->index(["client_id"], 'fk_client_items_clients1_idx');

            $table->index(["item_master_id"], 'fk_client_items_item_masters1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('client_id', 'fk_client_items_clients1_idx')
                ->references('id')->on('clients')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('item_master_id', 'fk_client_items_item_masters1_idx')
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
