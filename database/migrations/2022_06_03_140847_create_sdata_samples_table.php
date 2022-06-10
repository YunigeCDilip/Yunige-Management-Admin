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
    public $tableName = 'sdata_samples';

    /**
     * Run the migrations.
     * @table sdata_samples
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedBigInteger('wdata_id');
            $table->unsignedBigInteger('sdata_id');

            $table->index(["wdata_id"], 'fk_sdata_samples_wdata1_idx');

            $table->index(["sdata_id"], 'fk_sdata_samples_sdatas1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('wdata_id', 'fk_sdata_samples_wdata1_idx')
                ->references('id')->on('wdatas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sdata_id', 'fk_sdata_samples_sdatas1_idx')
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
        Schema::dropIfExists($this->tableName);
    }
};
