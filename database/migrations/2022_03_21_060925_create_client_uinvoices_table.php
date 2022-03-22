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
    public $tableName = 'client_uinvoices';

    /**
     * Run the migrations.
     * @table client_uinvoice
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('uinvoice_id');

            $table->index(["client_id"], 'fk_client_uinvoice_clients1_idx');

            $table->index(["uinvoice_id"], 'fk_client_uinvoice_uinvoices1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('client_id', 'fk_client_uinvoice_clients1_idx')
                ->references('id')->on('clients')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('uinvoice_id', 'fk_client_uinvoice_uinvoices1_idx')
                ->references('id')->on('uinvoices')
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
