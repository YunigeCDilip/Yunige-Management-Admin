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
    public $tableName = 'amazon_progress';

    /**
     * Run the migrations.
     * @table amazon_progress
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->longText('name')->nullable();
            $table->string('airtable_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('proposal_no', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('pickup', 255)->nullable();
            $table->longText('memo')->nullable();
            $table->string('delivery_company', 255)->nullable();
            $table->string('tracking_no', 255)->nullable();
            $table->text('tracking_url', 255)->nullable();
            $table->string('champain', 100)->nullable();
            $table->string('translation', 255)->nullable();
            $table->tinyInteger('done')->default('0');
            $table->string('case_no', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(["user_id"], 'fk_amazon_progress_users_idx');
            $table->foreign('user_id', 'fk_amazon_progress_users_idx')
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
