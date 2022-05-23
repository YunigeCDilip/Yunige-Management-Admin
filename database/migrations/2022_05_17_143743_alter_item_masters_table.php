<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_masters', function (Blueprint $table) {
            $table->text('label_link')->nullable()->after('weight2');
            $table->timestamp('label_pdf_date')->nullable()->after('label_link');
            $table->string('stricted_words')->nullable()->after('label_pdf_date');
            $table->string('w_no')->nullable()->after('stricted_words');
            $table->longText('ing_list')->nullable()->after('w_no');
            $table->timestamp('label_date')->nullable()->after('ing_list');
            $table->longText('rec_mark')->nullable()->after('label_date');
            $table->string('sampling')->nullable()->after('rec_mark');
            $table->string('lot_sampling')->nullable()->after('sampling');
            $table->string('product_nickname')->nullable()->after('lot_sampling');
            $table->float('outer_height')->nullable()->after('product_nickname');
            $table->float('outer_width')->nullable()->after('outer_height');
            $table->float('unit_width')->nullable()->after('outer_width');
            $table->float('unit_height')->nullable()->after('unit_width');
            $table->string('origin')->nullable()->after('unit_height');
            $table->string('lot_no')->nullable()->after('origin');
            $table->string('bbd')->nullable()->after('lot_no');
            $table->text('label_remarks')->nullable()->after('bbd');
            $table->timestamp('lot_arr_date')->nullable()->after('label_remarks');
            $table->timestamp('sample_date')->nullable()->after('lot_arr_date');
            $table->string('label_photo')->nullable()->after('sample_date');
            $table->string('amazon_req')->nullable()->after('label_photo');
            $table->string('outer_label_pos')->nullable()->after('amazon_req');
            $table->string('unit_label_pos')->nullable()->after('outer_label_pos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_masters', function (Blueprint $table) {
            $table->dropColumn('label_link');
            $table->dropColumn('label_pdf_date');
            $table->dropColumn('stricted_words');
            $table->dropColumn('w_no');
            $table->dropColumn('ing_list');
            $table->dropColumn('label_date');
            $table->dropColumn('rec_mark');
            $table->dropColumn('sampling');
            $table->dropColumn('lot_sampling');
            $table->dropColumn('product_nickname');
            $table->dropColumn('outer_height');
            $table->dropColumn('outer_width');
            $table->dropColumn('unit_width');
            $table->dropColumn('unit_height');
            $table->dropColumn('origin');
            $table->dropColumn('lot_no');
            $table->dropColumn('bbd');
            $table->dropColumn('label_remarks');
            $table->dropColumn('lot_arr_date');
            $table->dropColumn('sample_date');
            $table->dropColumn('label_photo');
            $table->dropColumn('amazon_req');
            $table->dropColumn('outer_label_pos');
            $table->dropColumn('unit_label_pos');
        });
    }
};
