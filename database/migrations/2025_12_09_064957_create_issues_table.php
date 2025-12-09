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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scan_id')->constrained()->onDelete('cascade');
            $table->enum('severity', ['critical', 'moderate', 'minor']);
            $table->string('page_url');
            $table->string('issue_type');
            $table->enum('wcag_level', ['A', 'AA', 'AAA']);
            $table->string('wcag_rule');
            $table->text('description');
            $table->text('element_selector')->nullable();
            $table->text('element_html')->nullable();
            $table->text('fix_sugesstion')->nullable();
            $table->text('code_before')->nullable();
            $table->text('code_after')->nullable();
            $table->enum('status', ['unresolved', 'resolved', 'ignored'])->default('unresolved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
