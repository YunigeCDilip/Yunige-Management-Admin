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
    public $tableName = 'client_vinvoices';

    /**
     * Run the migrations.
     * @table client_vinvoice
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('vinvoice_id');

            $table->index(["client_id"], 'fk_client_vinvoice_clients1_idx');

            $table->index(["vinvoice_id"], 'fk_client_vinvoice_vinvoices1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('client_id', 'fk_client_vinvoice_clients1_idx')
                ->references('id')->on('clients')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('vinvoice_id', 'fk_client_vinvoice_vinvoices1_idx')
                ->references('id')->on('vinvoices')
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
