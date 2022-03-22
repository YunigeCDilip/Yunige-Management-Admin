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
    public $tableName = 'clients';

    /**
     * Run the migrations.
     * @table clients
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('serial_number');
            $table->string('airtable_id')->nullable();
            $table->text('client_name');
            $table->string('ja_name')->nullable();
            $table->string('en_name')->nullable();
            $table->unsignedBigInteger('shipper_id')->nullable();
            $table->unsignedBigInteger('client_category_id')->nullable();
            $table->longText('hp')->nullable();
            $table->string('request')->nullable();
            $table->longText('dropbox_link')->nullable();
            $table->longText('foreign_dropbox_link')->nullable();
            $table->longText('foreign_noti')->nullable();
            $table->string('warehouse_remarks')->nullable();
            $table->string('customer_classification')->nullable();
            $table->string('invoice')->nullable();
            $table->string('company_tel', 45)->nullable();
            $table->string('fax', 45)->nullable();
            $table->string('warehouse_mgnt_copy')->nullable();
            $table->unsignedBigInteger('movement_confirmation_id')->nullable();
            $table->string('work_management', 100)->nullable();
            $table->string('table_30', 45)->nullable();
            $table->string('email_2', 45)->nullable();
            $table->tinyInteger('sugio_book_print')->default('0');
            $table->tinyInteger('yamazaki_book_print')->default('0');
            $table->tinyInteger('on_dropbox')->default('0');
            $table->tinyInteger('on_airtable')->default('0');
            $table->unsignedBigInteger('foreign_delivery_classifications_id')->nullable();
            $table->unsignedBigInteger('request_client_id')->nullable();
            $table->dateTime('takatsu_working_date')->nullable();
            $table->longText('product_master')->nullable();
            $table->string('field_61', 45)->nullable();

            $table->index(["shipper_id"], 'fk_clients_shippers_idx');

            $table->index(["client_category_id"], 'fk_clients_client_categories1_idx');

            $table->index(["movement_confirmation_id"], 'fk_clients_movement_confirmations1_idx');

            $table->index(["foreign_delivery_classifications_id"], 'fk_clients_foreign_delivery_classifications1_idx');

            $table->index(["request_client_id"], 'fk_clients_clients1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('shipper_id', 'fk_clients_shippers_idx')
                ->references('id')->on('shippers')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('client_category_id', 'fk_clients_client_categories1_idx')
                ->references('id')->on('client_categories')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('movement_confirmation_id', 'fk_clients_movement_confirmations1_idx')
                ->references('id')->on('movement_confirmations')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('foreign_delivery_classifications_id', 'fk_clients_foreign_delivery_classifications1_idx')
                ->references('id')->on('foreign_delivery_classifications')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('request_client_id', 'fk_clients_clients1_idx')
                ->references('id')->on('clients')
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
