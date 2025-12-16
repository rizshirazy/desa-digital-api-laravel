<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_assistance_recipients', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('social_assistance_id');
            $table->foreign('social_assistance_id')->references('id')->on('social_assistances');

            $table->uuid('head_of_family_id');
            $table->foreign('head_of_family_id')->references('id')->on('head_of_families');

            $table->decimal('amount', 10, 2);
            $table->longText('reason');
            $table->string('bank');
            $table->integer('account_number');
            $table->string('proof');
            $table->enum('status', ['pending', 'approved', 'rejected']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_assistance_recipients');
    }
};
