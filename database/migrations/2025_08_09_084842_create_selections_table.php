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
        Schema::create('selections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('applicant_id')->references('id')->on('applicants');
            $table->foreignUuid('job_post_category_id')->references('id')->on('job_post_categories');
            $table->enum("stage", ["portfolio", "interview", "medical_checkup"]);
            $table->enum("status", ["pending", "in_review", "accepted", "rejected"])->default("pending");
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selections');
    }
};
