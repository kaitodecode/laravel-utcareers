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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('company_id')->references('id')->on('companies');
            $table->string("title");
            $table->text("description");
            $table->text("requirements");
            $table->text("benefits");
            $table->enum("type", ["full_time", "part_time", "contract", "remote"]);
            $table->enum("status", ["active", "inactive"])->default("active");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
