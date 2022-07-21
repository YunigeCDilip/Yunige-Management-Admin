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
        Schema::table('wdetails', function($table) {
            $table->unsignedBigInteger('item_master_id')->after('work_instruction')->nullable();
            $table->index(["item_master_id"], 'fk_wdetails_item_masters12_idx');

            $table->foreign('item_master_id', 'fk_wdetails_item_masters12_idx')
                ->references('id')->on('item_masters')
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
        Schema::table('wdetails', function($table) {
            $table->dropColumn('item_master_id');
        });
    }
};
