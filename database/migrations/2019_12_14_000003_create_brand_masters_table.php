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
    public $tableName = 'brand_masters';

    /**
     * Run the migrations.
     * @table brand_masters
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('airtable_id')->nullable();
            $table->text('name');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('ja_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->tinyInteger('parallel_import')->default('0');
            $table->text('brand_logo')->nullable();
            $table->text('brand_url')->nullable();
            $table->tinyInteger('check')->default('0');
            $table->longText('remarks')->nullable();

            $table->index(["country_id"], 'fk_brand_masters_countries1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('country_id', 'fk_brand_masters_countries1_idx')
                ->references('id')->on('countries')
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
