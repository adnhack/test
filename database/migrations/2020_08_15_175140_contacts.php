<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); //$table->bigIncrements('id')->nullable($value = false)->unsigned();
            $table->integer('team_id', 10)->unsigned();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci');
            $table->string('phone', 255)->nullable($value = false)->collation('utf8mb4_unicode_ci');
            $table->string('email', 255)->collation('utf8mb4_unicode_ci');
            $table->integer('sticky_phone_number_id', 11)->unsigned();
            $table->timestamps('created_at');
            $table->timestamps('updated_at');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
