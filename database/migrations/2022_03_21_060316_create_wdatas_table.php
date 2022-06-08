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
    public $tableName = 'wdatas';

    /**
     * Run the migrations.
     * @table wdata
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->longText('name');
            $table->string('warehouse_number');
            $table->string('airtable_id')->nullable();
            $table->unsignedBigInteger('inbound_status_id')->nullable();
            $table->unsignedBigInteger('reason_id')->nullable();
            $table->unsignedBigInteger('carrier_id')->nullable();
            $table->unsignedBigInteger('wdata_pic_id')->nullable();
            $table->unsignedBigInteger('wdata_status_id')->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->date('inbound_eta')->nullable();
            $table->date('outbound_eta')->nullable();
            $table->string('permit_number')->nullable();
            $table->longText('irregular')->nullable();
            $table->string('track_number')->nullable();
            $table->longText('memo_invoice')->nullable();
            $table->longText('pickup')->nullable();
            $table->date('pickup_date')->nullable();
            $table->date('free_time')->nullable();
            $table->date('hakamichi')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->dateTime('pickup_date_possible')->nullable();
            $table->longText('custom_broker_2')->nullable();
            $table->string('inbound')->nullable();
            $table->string('label_status')->nullable();
            $table->string('paid_international')->nullable();
            $table->string('not_match')->nullable();
            $table->string('fba_track_no')->nullable();
            $table->string('plate_number', 45)->nullable();
            $table->string('paid_tax', 45)->nullable();
            $table->string('unknown_korea', 45)->nullable();
            $table->string('unknown_korea2')->nullable();
            $table->string('arriaval_ctn')->nullable();
            $table->longText('memok')->nullable();
            $table->string('track_jp')->nullable();
            $table->string('outerdamage', 100)->nullable();
            $table->longText('arrival_pic_url')->nullable();
            $table->longText('field_139')->nullable();
            $table->longText('invoice_memo')->nullable();
            $table->string('invoice_amount')->nullable();
            $table->date('invoice_date')->nullable();
            $table->unsignedBigInteger('track_input_id')->nullable();
            $table->unsignedBigInteger('shipment_method_id')->nullable();
            $table->unsignedInteger('warehouse_pic_id')->nullable();
            $table->unsignedBigInteger('incomplete_status_id')->nullable();
            $table->enum('permit_pic', ['梶村', '高津'])->nullable();
            $table->unsignedBigInteger('container_id')->nullable();
            $table->unsignedBigInteger('delivery_place_id')->nullable();
            $table->unsignedBigInteger('transfer_id')->nullable();
            $table->unsignedBigInteger('pick_direction_id')->nullable();
            $table->unsignedBigInteger('inter_assist_inbound_id')->nullable();

            $table->unique(["warehouse_number"], 'warehouse_number_UNIQUE');

            $table->index(["inbound_status_id"], 'fk_wdatas_inbound_statuses1_idx');

            $table->index(["reason_id"], 'fk_wdata_reasons1_idx');

            $table->index(["carrier_id"], 'fk_wdata_carriers1_idx');

            $table->index(["wdata_pic_id"], 'fk_wdata_wdata_pics1_idx');

            $table->index(["wdata_status_id"], 'fk_wdata_wdata_statuses1_idx');

            $table->index(["track_input_id"], 'fk_wdata_track_inputs1_idx');

            $table->index(["shipment_method_id"], 'fk_wdata_shipment_methods1_idx');

            $table->index(["warehouse_pic_id"], 'fk_wdata_warehouse_pics1_idx');

            $table->index(["incomplete_status_id"], 'fk_wdata_incomplete_statuses1_idx');

            $table->index(["container_id"], 'fk_wdata_containers1_idx');

            $table->index(["delivery_place_id"], 'fk_wdata_delivery_places1_idx');

            $table->index(["pick_direction_id"], 'fk_wdata_pick_directions1_idx');

            $table->index(["transfer_id"], 'fk_wdata_transfers1_idx');

            $table->index(["delivery_id"], 'fk_wdata_deliveries1_idx');

            $table->index(["inter_assist_inbound_id"], 'fk_wdata_inter_assist_inbounds1_idx');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('inbound_status_id', 'fk_wdatas_inbound_statuses1_idx')
                ->references('id')->on('inbound_statuses')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('reason_id', 'fk_wdata_reasons1_idx')
                ->references('id')->on('reasons')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('carrier_id', 'fk_wdata_carriers1_idx')
                ->references('id')->on('carriers')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('wdata_pic_id', 'fk_wdata_wdata_pics1_idx')
                ->references('id')->on('wdata_pics')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('wdata_status_id', 'fk_wdata_wdata_statuses1_idx')
                ->references('id')->on('wdata_statuses')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('track_input_id', 'fk_wdata_track_inputs1_idx')
                ->references('id')->on('track_inputs')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('shipment_method_id', 'fk_wdata_shipment_methods1_idx')
                ->references('id')->on('shipment_methods')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('warehouse_pic_id', 'fk_wdata_warehouse_pics1_idx')
                ->references('id')->on('warehouse_pics')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('incomplete_status_id', 'fk_wdata_incomplete_statuses1_idx')
                ->references('id')->on('incomplete_statuses')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('container_id', 'fk_wdata_containers1_idx')
                ->references('id')->on('containers')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('delivery_place_id', 'fk_wdata_delivery_places1_idx')
                ->references('id')->on('delivery_places')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('pick_direction_id', 'fk_wdata_pick_directions1_idx')
                ->references('id')->on('pick_directions')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('transfer_id', 'fk_wdata_transfers1_idx')
                ->references('id')->on('transfers')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('inter_assist_inbound_id', 'fk_wdata_inter_assist_inbounds1_idx')
                ->references('id')->on('inter_assist_inbounds')
                ->onDelete('no action')
                ->onUpdate('no action');


            $table->foreign('delivery_id', 'fk_wdata_deliveries1_idx')
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
