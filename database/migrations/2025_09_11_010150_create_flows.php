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
        Schema::create('flows', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description")->nullable();
            $table->string("logo")->nullable();
            $table->bigInteger("price")->nullable();
            $table->integer("discount")->nullable();
            $table->timestamp("discount_expired_at")->nullable();
            $table->uuid("unique_id");
            $table->json("pattern");
            $table->foreignId("user_id")->constrained("users");
            $table->integer("workspace_id")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flows');
    }
};
