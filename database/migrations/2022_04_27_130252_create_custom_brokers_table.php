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
    public $tableName = 'custom_brokers';

    /**
     * Run the migrations.
     * @table custom_brokers
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('airtable_id', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('telephone_no', 255)->nullable();
            $table->string('fax_number', 255)->nullable();
            $table->text('url')->nullable();
            $table->text('url_back')->nullable();
            $table->longText('data_by_matter')->nullable();
            $table->string('store_house', 255)->nullable();
            $table->string('test', 255)->nullable();
            $table->string('product_master', 255)->nullable();
            $table->string('table_70', 255)->nullable();
            $table->longText('warehouse_2')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('request_otsunaka', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
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
