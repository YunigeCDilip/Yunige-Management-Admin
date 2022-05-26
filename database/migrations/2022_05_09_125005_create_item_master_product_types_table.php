<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_master_product_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_master_id');
            $table->unsignedBigInteger('product_type_id');

            $table->index(["product_type_id"], 'fk_item_ma_p_types_product_ty1_idx');

            $table->index(["item_master_id"], 'fk_item_ma_p_types_item_masters1_idx');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('item_master_id', 'fk_item_ma_p_types_item_masters1_idx')
                ->references('id')->on('item_masters')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('product_type_id', 'fk_item_ma_p_types_product_ty1_idx')
                ->references('id')->on('product_types')
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
        Schema::dropIfExists('item_master_product_types');
    }
};
