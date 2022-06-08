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
    public $tableName = 'sdatas';

    /**
     * Run the migrations.
     * @table sdatas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->longText('name');
            $table->string('airtable_id')->nullable();
            $table->string('serial')->nullable();
            $table->string('case_number')->nullable();
            $table->tinyInteger('amazon_sold')->default('0');
            $table->string('by_country')->nullable();
            $table->string('case_in_charge')->nullable()->comment('form selection data');
            $table->longText('categories')->nullable();
            $table->longText('memo')->nullable();
            $table->date('matter_date')->nullable();
            $table->string('priority')->nullable()->comment('Form selection data');
            $table->date('priority_change_date')->nullable();
            $table->string('ingredient_progress')->nullable()->comment('Form selection data');
            $table->date('ingredient_date')->nullable();
            $table->integer('ingredient_number_ok')->nullable();
            $table->integer('total_ingredient')->nullable();
            $table->string('notification_progress')->nullable()->comment('Form selection data');
            $table->date('application_date')->nullable();
            $table->integer('foreign_noti')->nullable();
            $table->integer('manufact_sales_noti')->nullable();
            $table->integer('change_noti')->nullable();
            $table->string('sample_progress')->nullable()->comment('Form selection data');
            $table->date('sample_date')->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->string('sample_tracking_no')->nullable();
            $table->text('tracking_url')->nullable();
            $table->string('label_creation_progress')->nullable()->comment('Form selection data');
            $table->date('label_creation_date')->nullable();
            $table->integer('no_label_design')->nullable();
            $table->string('data_confirmation')->nullable()->comment('Form selection data');
            $table->date('data_creation_date')->nullable();
            $table->string('customer_service')->nullable()->comment('Form selection data');
            $table->date('corresponding_date')->nullable();
            $table->string('printing_progress')->nullable()->comment('Form selection data');
            $table->date('print_date')->nullable();
            $table->string('delivery_category')->nullable();
            $table->date('label_delivery_date')->nullable();
            $table->tinyInteger('ingredient_billing_completed')->default('0');
            $table->tinyInteger('application_completed')->default('0');
            $table->tinyInteger('label_design_completed')->default('0');
            $table->date('ingredient_billing_date')->nullable();
            $table->date('application_completed_date')->nullable();
            $table->date('label_completed_date')->nullable();
            $table->bigInteger('analysis_amount')->nullable();
            $table->tinyInteger('other_billed')->default('0');
            $table->date('other_billed_date')->nullable();
            $table->tinyInteger('all_completed_billing')->default('0');
            $table->date('all_completed_date')->nullable();
            $table->unsignedBigInteger('amazon_progress_id')->nullable();
            $table->integer('created_serial_no')->nullable();
            $table->integer('revised_label')->nullable();
            $table->tinyInteger('billing_competed_kurohara')->default('0');
            $table->string('amazon_quote')->nullable()->comment('Form data selection');
            $table->string('declatation_number')->nullable();
            $table->string('product_master')->nullable();
            $table->string('label_requester')->nullable()->comment('Form selection data');
            $table->string('double_checker')->nullable()->comment('Form selection data');
            $table->tinyInteger('double_checked')->default('0');
            $table->bigInteger('ingredient_costs')->default('0');
            $table->bigInteger('foreign_noti_fee')->default('0');
            $table->bigInteger('manufact_sales_noti_fee')->default('0');
            $table->bigInteger('change_noti_fee')->default('0');
            $table->bigInteger('label_design_fee')->default('0');
            $table->tinyInteger('print_components')->default('0');
            $table->tinyInteger('stamp_print_murata')->default('0');
            $table->tinyInteger('stamp_print_sugio')->default('0');
            $table->string('labeling_priority')->nullable()->comment('Form data selection');
            $table->longText('calculation')->nullable();
            $table->longText('ingredient_request_takeda')->nullable();
            $table->longText('product_master_request')->nullable();
            $table->integer('count_product_masters')->default('0');
            $table->text('ingredient_special_note')->nullable();
            $table->tinyInteger('ingredient_transmission')->default('0');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('transmission_international')->default('0');
            $table->tinyInteger('transmission_national')->default('0');
            $table->longText('takeda_email')->nullable();
            $table->tinyInteger('kanban_printed')->default('0');
            $table->text('storage_link')->nullable();
            $table->text('test_link')->nullable();
            $table->unsignedBigInteger('label_requester_id')->nullable();
            $table->longText('supplementary_memo')->nullable();
            $table->tinyInteger('send_label_creation')->default('0');
            $table->date('label_creation_request')->nullable();
            $table->string('email')->nullable();

            $table->index(["delivery_id"], 'fk_sdatas_deliveries1_idx');
            $table->index(["user_id"], 'fk_sdatas_users1_idx');
            $table->index(["label_requester_id"], 'fk_sdatas_users2_idx');

            $table->index(["amazon_progress_id"], 'fk_sdatas_amazon_progress1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('delivery_id', 'fk_sdatas_deliveries1_idx')
                ->references('id')->on('deliveries')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('amazon_progress_id', 'fk_sdatas_amazon_progress1_idx')
                ->references('id')->on('amazon_progress')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_sdatas_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('label_requester_id', 'fk_sdatas_users2_idx')
                ->references('id')->on('users')
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
