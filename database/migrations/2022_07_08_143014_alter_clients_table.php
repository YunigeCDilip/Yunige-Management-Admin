<?php

use Illuminate\Database\Migrations\Migration;
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
        Schema::table('clients', function($table) {
            $table->unsignedBigInteger('incharge_id')->after('airtable_id')->nullable();
        
            $table->index(["incharge_id"], 'fk_clients_users1_idx');

            $table->foreign('incharge_id', 'fk_clients_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->longText('customer_memo')->after('field_61')->nullable();
        });

        Schema::table('client_contacts', function($table) {
            $table->string('delivery_address', 255)->after('pic_add')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function($table) {
            $table->dropColumn('incharge_id');
            $table->dropColumn('customer_memo');
        });

        Schema::table('client_contacts', function($table) {
            $table->dropColumn('pic_add');
        });
    }
};
