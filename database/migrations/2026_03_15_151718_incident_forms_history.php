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
        Schema::create('incident_forms_history', function (Blueprint $table) {
            $table->id();
            
            $table->string('action_type', 20);
            
            $table->foreignId('incident_forms_id')->constrained('incident__forms')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('zonal_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table->string('reporter_name');
            $table->string('importance');
            $table->text('description');
            $table->dateTime('start_time');
            $table->dateTime('first_report_time');
            $table->dateTime('initial_etr');
            $table->dateTime('resulation_time')->nullable();
            $table->string('status')->default('Open');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
            
            $table->index('action_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_forms_history');
    }
};