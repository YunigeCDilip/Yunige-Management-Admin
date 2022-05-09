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
    public $tableName = 'wdetails';

    /**
     * Run the migrations.
     * @table wdetails
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wdata_id');
            $table->longText('name');
            $table->string('airtable_id')->nullable();
            $table->string('customer_number')->nullable();
            $table->string('arrival_progress')->nullable();
            $table->date('progress_date')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->string('goods_receipt')->nullable();
            $table->string('work_order')->nullable();
            $table->string('work_instruction')->nullable();
            $table->string('product_lists')->nullable();
            $table->string('code')->nullable();
            $table->string('with_without_label')->nullable();
            $table->string('data_by_matter')->nullable();
            $table->string('pdf_label')->nullable();
            $table->string('single_item')->nullable();
            $table->string('blindfold_label')->nullable();
            $table->string('sea_label')->nullable();
            $table->string('capacity')->nullable();
            $table->string('pic')->nullable();
            $table->string('est_qty')->nullable();
            $table->string('qty_received')->nullable();
            $table->string('adverse_number')->nullable();
            $table->string('too_much_fx')->nullable();
            $table->string('shipable_qty_fx')->nullable();
            $table->string('bad_photo')->nullable();
            $table->string('fba_shipping_label')->nullable();
            $table->boolean('ready_in_advance')->nullable();
            $table->string('various_noti_docs')->nullable();
            $table->string('tracking_no')->nullable();
            $table->string('series')->nullable();
            $table->boolean('shipment_completed')->nullable();
            $table->date('shipment_completion_date')->nullable();
            $table->string('receipt_progress')->nullable();
            $table->string('receipt_status')->nullable();
            $table->string('determine_ingredient')->nullable();
            $table->string('barcode')->nullable();
            $table->string('sh')->nullable();
            $table->string('ename')->nullable();
            $table->string('exterior_number')->nullable();
            $table->string('body_fx')->nullable();
            $table->string('exterior_fx')->nullable();
            $table->string('items_pasted_overseas')->nullable();
            $table->string('overseas_pasting_fx')->nullable();
            $table->string('fba_label_attached')->nullable();
            $table->string('fba_sticking_price')->nullable();
            $table->string('blindfoded_labels')->nullable();
            $table->string('blindfolded_price_fx')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('arrival_place')->nullable();
            $table->string('billing_completed')->nullable();
            $table->string('work_progress')->nullable();
            $table->string('delivery_address')->nullable();
            $table->date('est_shipping_date')->nullable();
            $table->string('fnsku_or_not')->nullable();
            $table->string('dependencies')->nullable();
            $table->string('kanban_replace_date')->nullable();
            $table->string('outbound_report')->nullable();
            $table->string('shipment_date')->nullable();
            $table->string('labeling_status')->nullable();
            $table->string('breakdown')->nullable();
            $table->string('url')->nullable();
            $table->string('absence_shrink')->nullable();
            $table->string('absence_seal')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('name_by_type')->nullable();
            $table->string('period_of_use')->nullable();
            $table->string('prohibited_words')->nullable();
            $table->string('banned_wording')->nullable();
            $table->string('storage_lot')->nullable();
            $table->string('inci_ingredient')->nullable();
            $table->string('ja_ingredient')->nullable();

            $table->index(["wdata_id"], 'fk_wdetails_wdata1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('wdata_id', 'fk_wdetails_wdata1_idx')
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
