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
        Schema::table('flows', function (Blueprint $table) {
            $table->bigInteger("price")->default(0);
            $table->text("content")->nullable();
            $table->text("description")->nullable();
            $table->string("icon")->nullable();
            $table->integer("discount")->default(0);
            $table->integer("has_marketplace")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flows', function (Blueprint $table) {
            $table->dropColumn("price");
            $table->dropColumn("description");
            $table->dropColumn("content");
            $table->dropColumn("icon");
            $table->dropColumn("discount");
            $table->dropColumn("has_marketplace");
        });
    }
};
