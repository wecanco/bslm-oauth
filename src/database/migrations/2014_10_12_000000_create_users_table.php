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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->json('data');
            $table->bigInteger('basalam_id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('hash_id');
            $table->bigInteger('as_user')->nullable();
            $table->bigInteger('manager_id')->nullable();
            $table->bigInteger('mobile');
            $table->integer('vendor_status');
            $table->integer('role')->default(1);
            $table->string('name');
            $table->bigInteger('credit')->default(0);
            $table->bigInteger('ecredit')->default(0);
            $table->dateTime('accept_contract_at')->default('now()');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
