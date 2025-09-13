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
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->string("icon");
            $table->string("slug")->nullable();
            $table->text("background")->nullable();
            $table->integer("parent_id")->default(0);
            $table->enum("type", ["tools", "core"])->default("tools");
            $table->integer("is_mcp_server")->default(0);
            $table->integer("loop")->default(0);
            $table->integer("input")->default(0);
            $table->integer("output")->default(0);
            $table->integer("orders")->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
