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
    public $tableName = 'wdata_attachments';

    /**
     * Run the migrations.
     * @table wdata_attachments
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wdata_id');
            $table->string('type')->comment('Invoice, PackingList, BL, AN, ImportPermit, DO, WInvoice, CustomBInvocie, FBALabel, InvocieKR, ArrivalPic, ArrivalPic, WDetail, InboundProof');
            $table->string('file_name')->nullable();
            $table->string('ext')->nullable();
            $table->tinyInteger('airtable')->default('0');
            $table->longText('url');

            $table->index(["wdata_id"], 'fk_wdata_attachments_wdata1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('wdata_id', 'fk_wdata_attachments_wdata1_idx')
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
