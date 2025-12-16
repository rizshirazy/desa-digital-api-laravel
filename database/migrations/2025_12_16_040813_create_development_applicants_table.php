<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('development_applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('development_id');
            $table->foreign('development_id')->on('id')->references('developments');

            $table->uuid('user_id');
            $table->foreign('user_id')->on('id')->references('users');

            $table->enum('status', ['approved', 'pending', 'rejected']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('development_applicants');
    }
};
