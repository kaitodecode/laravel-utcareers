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
        Schema::create('job_categories_job_posts', function (Blueprint $table) {
            $table->foreignUuid("job_category_id")->references("id")->on("job_categories");
            $table->foreignUuid("job_post_id")->references("id")->on("job_posts");
            $table->primary(["job_category_id", "job_post_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_categories_job_posts');
    }
};
