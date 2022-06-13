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
    public $tableName = 'inter_assist_outbound_files';

    /**
     * Run the migrations.
     * @table inter_assist_outbound_files
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inter_assist_outbound_id');
            $table->string('type')->comment('FBA Reservation Slips');
            $table->string('file_name')->nullable();
            $table->string('ext')->nullable();
            $table->longText('url');

            $table->index(["inter_assist_outbound_id"], 'fk_int_od_files_iaoutbounds1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('inter_assist_outbound_id', 'fk_int_od_files_iaoutbounds1_idx')
                ->references('id')->on('inter_assist_outbounds')
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
