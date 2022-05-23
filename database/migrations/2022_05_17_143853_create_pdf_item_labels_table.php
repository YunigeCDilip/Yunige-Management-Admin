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
        Schema::create('pdf_item_labels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_master_id');
            $table->enum('type', array('LabelPDF', 'IngListData', 'LabelAppPDF'))->nullable();
            $table->text('file')->nullable();
            $table->index(["item_master_id"], 'fk_pdf_item_labels_item_masters1_idx');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('item_master_id', 'fk_pdf_item_labels_item_masters1_idx')
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
        Schema::dropIfExists('pdf_item_labels');
    }
};
