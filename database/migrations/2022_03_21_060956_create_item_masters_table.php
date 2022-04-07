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
    public $tableName = 'item_masters';

    /**
     * Run the migrations.
     * @table item_masters
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->longText('product_name');
            $table->string('airtable_id')->nullable();
            $table->unsignedBigInteger('brand_master_id')->nullable();
            $table->unsignedBigInteger('item_category_id')->nullable();
            $table->unsignedBigInteger('item_label_id')->nullable();
            $table->unsignedBigInteger('shipper_id')->nullable();
            $table->string('product_barcode', 255)->nullable();
            $table->longText('description')->nullable();
            $table->longText('jp_description')->nullable();
            $table->timestamp('barcode_entry_date')->nullable();
            $table->string('jp_name', 255)->nullable();
            $table->string('productgname', 255)->nullable();
            $table->string('gname', 255)->nullable();
            $table->string('product_name_1', 255)->nullable();
            $table->string('product_name_2', 255)->nullable();
            $table->string('availabity', 255)->nullable();
            $table->string('unit', 255)->nullable();
            $table->string('weight', 255)->nullable();
            $table->string('weight2', 255)->nullable();
            $table->unsignedBigInteger('product_type_id')->nullable();

            $table->index(["brand_master_id"], 'fk_item_masters_brand_masters1_idx');

            $table->index(["item_category_id"], 'fk_item_masters_item_categories1_idx');

            $table->index(["item_label_id"], 'fk_item_masters_item_labels1_idx');

            $table->index(["shipper_id"], 'fk_item_masters_shippers1_idx');

            $table->index(["product_type_id"], 'fk_item_masters_product_types1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('brand_master_id', 'fk_item_masters_brand_masters1_idx')
                ->references('id')->on('brand_masters')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('item_category_id', 'fk_item_masters_item_categories1_idx')
                ->references('id')->on('item_categories')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('item_label_id', 'fk_item_masters_item_labels1_idx')
                ->references('id')->on('item_labels')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('shipper_id', 'fk_item_masters_shippers1_idx')
                ->references('id')->on('shippers')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('product_type_id', 'fk_item_masters_product_types1_idx')
                ->references('id')->on('product_types')
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
