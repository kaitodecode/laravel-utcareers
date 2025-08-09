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
        Schema::create('job_post_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid("job_category_id")->references("id")->on("job_categories");
            $table->foreignUuid("job_post_id")->references("id")->on("job_posts");
            $table->enum("type", ["full_time", "part_time", "contract", "remote"]);
            $table->integer("required_count")->default(1);
            $table->text("description")->nullable();
            $table->text("requirements")->nullable();
            $table->text("benefits")->nullable();
            $table->unique(["job_post_id", "job_category_id"]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_categories');
    }
};
