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
            $table->string('name');
            $table->date('date')->default(now());
            $table->foreignId('category_id')->nullable()->references('id')->on('task_categories')
                ->onDelete('set null')->onUpdate('set null');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')
                ->onDelete('set null')->onUpdate('set null');
            $table->integer('urgency')->default(1);
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
