<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('wsclient', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->unique();
            $table->string('secret_key');
            $table->string('key');
            $table->string('instansi');
            $table->integer('modulid');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('wsclient');
    }
};
