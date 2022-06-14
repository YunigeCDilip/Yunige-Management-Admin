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
    public $tableName = 'outbound_attachments';

    /**
     * Run the migrations.
     * @table outbound_attachments
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('outbound_id');
            $table->string('type')->comment('FBA Label, Others, InvoiceImageJudgment');
            $table->string('file_name')->nullable();
            $table->string('ext')->nullable();
            $table->tinyInteger('airtable')->default('0');
            $table->longText('url');

            $table->index(["outbound_id"], 'fk_outbound_attachments_outbound1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('outbound_id', 'fk_outbound_attachments_outbound1_idx')
                ->references('id')->on('outbounds')
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
