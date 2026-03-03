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
        Schema::create('incident__forms', function (Blueprint $table) {
        $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); 
            $table->string('zonal_name'); 
            $table->string('category');   
            $table->enum('importance', ['High', 'Mid', 'Low'])->default('Mid');
            $table->text('description');
            
            $table->timestamp('start_time')->nullable(); 
            $table->timestamp('initial_etr')->nullable();
            
            $table->enum('status', ['Open', 'In Progress', 'Resolved'])->default('Open');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident__forms');
    }
};
