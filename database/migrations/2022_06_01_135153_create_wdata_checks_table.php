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
    public $tableName = 'wdata_checks';

    /**
     * Run the migrations.
     * @table wadata_checks
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wdata_id');
            $table->tinyInteger('finished')->default('0');
            $table->tinyInteger('wfinish')->default('0');
            $table->tinyInteger('nakamichi_finished')->default('0');
            $table->tinyInteger('mail_sent')->default('0');
            $table->tinyInteger('check_finished')->default('0');
            $table->tinyInteger('ok')->default('0');
            $table->tinyInteger('check')->default('0');
            $table->tinyInteger('import_permit_check')->default('0');
            $table->tinyInteger('delete_check')->default('0');
            $table->tinyInteger('panel_check')->default('0');
            $table->tinyInteger('invoice_list')->default('0');

            $table->index(["wdata_id"], 'fk_wadata_checks_wdata1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('wdata_id', 'fk_wadata_checks_wdata1_idx')
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
