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
    public $tableName = 'category_wdatas';

    /**
     * Run the migrations.
     * @table category_wdatas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wdata_id');
            $table->unsignedBigInteger('wdata_category_id');

            $table->index(["wdata_category_id"], 'fk_category_wdatas_wdata_categories1_idx');

            $table->index(["wdata_id"], 'fk_category_wdatas_wdata1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('wdata_category_id', 'fk_category_wdatas_wdata_categories1_idx')
                ->references('id')->on('wdata_categories')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('wdata_id', 'fk_category_wdatas_wdata1_idx')
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
