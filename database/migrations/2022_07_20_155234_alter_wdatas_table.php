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
        Schema::table('wdatas', function($table) {
            $table->unsignedBigInteger('incharge_id')->after('airtable_id')->nullable();
            $table->bigInteger('case_count')->after('permit_pic')->default(0);
            $table->string('transport_method')->comment('sea, air')->after('permit_pic')->nullable();
            $table->index(["incharge_id"], 'fk_wdatas_users12_idx');

            $table->foreign('incharge_id', 'fk_wdatas_users12_idx')
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
        Schema::table('wdatas', function($table) {
            $table->dropColumn('incharge_id');
            $table->dropColumn('case_count');
            $table->dropColumn('transport_method');
        });
    }
};
