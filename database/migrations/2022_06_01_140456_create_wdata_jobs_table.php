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
    public $tableName = 'wdata_jobs';

    /**
     * Run the migrations.
     * @table wdata_jobs
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wdata_id');
            $table->unsignedBigInteger('warehouse_job_id');

            $table->index(["wdata_id"], 'fk_wdata_jobs_wdata1_idx');

            $table->index(["warehouse_job_id"], 'fk_wdata_jobs_warehouse_jobs1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('wdata_id', 'fk_wdata_jobs_wdata1_idx')
                ->references('id')->on('wdatas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('warehouse_job_id', 'fk_wdata_jobs_warehouse_jobs1_idx')
                ->references('id')->on('warehouse_jobs')
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
