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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("description");
            $table->enum("priority",["High", "Mid", "Low"])->nullable();
            $table->boolean("completed")->default(false);
            $table->enum("status",["pending", "in_progress", "completed"])->default("pending");
            $table->foreignId("todolist_id")->constrained("todolists")->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
