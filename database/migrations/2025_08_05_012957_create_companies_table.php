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
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->string("email");
            $table->string("phone");
            $table->string("website")->nullable();
            $table->string("logo")->nullable();
            $table->text("address");
            $table->text("description")->nullable();
            $table->string("company_type")->nullable();
            $table->string("business_sector")->nullable();
            $table->foreignUuid("parent_company_id")->nullable()->references("id")->on("companies");
            $table->boolean("is_active")->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
