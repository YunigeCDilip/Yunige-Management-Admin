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
    public $tableName = 'outbounds';

    /**
     * Run the migrations.
     * @table outbounds
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('airtable_id', 255)->nullable();
            $table->string('name', 255);
            $table->unsignedBigInteger('wdata_id')->nullable();
            $table->json('warehouse_in_charge')->nullable();
            $table->tinyInteger('reserve')->default(0);
            $table->date('ship_date')->nullable();
            $table->date('create_date')->nullable();
            $table->date('estimited_ship_date')->nullable();
            $table->tinyInteger('completed')->default(0);
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->string('invoice_no', 255)->nullable();
            $table->string('additional_invoice_no', 255)->nullable();
            $table->string('fba_reservation_no', 255)->nullable();
            $table->date('fba_entry_date')->nullable();
            $table->integer('small_no')->nullable();
            $table->longText('special_notes')->nullable();
            $table->string('fba_no', 255)->nullable();
            $table->string('po_no', 255)->nullable();
            $table->text('url')->nullable();
            $table->text('next_url')->nullable();
            $table->tinyInteger('send_email')->default(0);
            $table->string('storehouse', 255)->nullable();
            $table->date('wait_date_create_modify')->nullable();
            $table->string('field_33', 255)->nullable();
            $table->string('field_34', 255)->nullable();
            $table->string('inter_assist_share', 255)->nullable();
            $table->text('url_delivery')->nullable();
            $table->text('mail_text')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(["wdata_id"], 'fk_wdatas_outbounds1_idx');

            $table->index(["delivery_id"], 'fk_deliveries_outbounds1_idx');

            $table->foreign('wdata_id', 'fk_wdatas_outbounds1_idx')
                ->references('id')->on('wdatas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('delivery_id', 'fk_deliveries_outbounds1_idx')
                ->references('id')->on('deliveries')
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
