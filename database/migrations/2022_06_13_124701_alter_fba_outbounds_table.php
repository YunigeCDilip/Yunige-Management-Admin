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
        if (Schema::hasColumn('fba_id', 'outbound_id')){
            Schema::table('fba_outbounds', function($table) {
                $table->dropColumn('fba_id');
                $table->dropColumn('outbound_id');
                $table->unsignedInteger('fba_id')->after('id');
                $table->unsignedBigInteger('outbound_id')->after('fba_id');
            
                $table->index(["fba_id"], 'fk_fba_lists_fba_outbounds1_idx');
    
                $table->index(["outbound_id"], 'fk_outbounds_fba_outbounds1_idx');

                $table->foreign('fba_id', 'fk_fba_lists_fba_outbounds1_idx')
                    ->references('id')->on('fba_lists')
                    ->onDelete('no action')
                    ->onUpdate('no action');
    
                $table->foreign('outbound_id', 'fk_outbounds_fba_outbounds1_idx')
                    ->references('id')->on('outbounds')
                    ->onDelete('no action')
                    ->onUpdate('no action');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fba_outbounds', function($table) {
            $table->dropColumn('fba_id');
            $table->dropColumn('outbound_id');
        });
    }
};
