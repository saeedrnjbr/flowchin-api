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
        Schema::create('flow_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("flow_id")->constrained("flows");
            $table->foreignId("integration_id")->constrained("integrations");
            $table->text("params");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flow_nodes');
    }
};
