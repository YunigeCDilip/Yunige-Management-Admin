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
        Schema::create('sdata_attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sdata_id');
            $table->string('type')->comment('invoice, ingredient_lists, label_data, component_check, qr_code');
            $table->string('file_name')->nullable();
            $table->string('ext')->nullable();
            $table->longText('url');

            $table->index(["sdata_id"], 'fk_sdata_attachments_sdata1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('sdata_id', 'fk_sdata_attachments_sdata1_idx')
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
        Schema::dropIfExists('sdata_attachments');
    }
};
