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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('access_token')->default('YOUR_SECRET_ACCESS_TOKEN');
            $table->binary('file_name');
            $table->binary('file_path');
            $table->string('file_type');
            $table->softDeletes();
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
