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
    public $tableName = 'inter_assist_outbounds';

    /**
     * Run the migrations.
     * @table inter_assist_outbounds
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('airtable_id', 255)->nullable();
            $table->string('inter_assist_id', 255);
            $table->date('etd_shipping_date')->nullable();
            $table->unsignedBigInteger('outbound_id')->nullable();
            $table->longText('remarks')->nullable();
            $table->tinyInteger('completion')->default(0);
            $table->string('fba_id', 255)->nullable();
            $table->tinyInteger('send_email')->default(0);
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(["outbound_id"], 'fk_outbounds_inter_assist_outbounds1_idx');

            $table->foreign('outbound_id', 'fk_outbounds_inter_assist_outbounds1_idx')
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
