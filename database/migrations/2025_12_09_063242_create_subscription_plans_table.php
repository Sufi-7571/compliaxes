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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('max_websites');
            $table->integer('scans_per_week');
            $table->boolean('fix_suggestions')->default(false);
            $table->boolean('pdf_export')->default(false);
            $table->boolean('api_access')->default(false);
            $table->boolean('issue_history')->default(false);
            $table->boolean('priority_scanning')->default(false);
            $table->integer('max_pages_per_scan')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
