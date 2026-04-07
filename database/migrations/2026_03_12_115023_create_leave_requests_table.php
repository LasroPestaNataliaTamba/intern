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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');

            // STEP APPROVAL
            $table->string('division_status')->default('pending');
            $table->string('hr_status')->default('pending');
            $table->string('director_status')->default('pending');

            // FINAL STATUS AUTO CALCULATED
            $table->string('final_status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
