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
    public $tableName = 'client_contacts';

    /**
     * Run the migrations.
     * @table client_contacts
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('contact_number', 255)->nullable();
            $table->string('seller_name', 255)->nullable();
            $table->longText('seller_add', 255)->nullable();
            $table->longText('office_add', 255)->nullable();
            $table->longText('pic_add')->nullable();

            $table->index(["client_id"], 'fk_client_contacts_clients1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('client_id', 'fk_client_contacts_clients1_idx')
                ->references('id')->on('clients')
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
