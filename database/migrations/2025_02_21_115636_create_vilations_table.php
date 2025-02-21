<?php

use App\Enums\VilationDetection;
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
        Schema::create('vilations', function (Blueprint $table) {
            $table->id();
            $table->string('violation_type');
            $table->string('detected_by')->default(VilationDetection::AI);
            $table->string('violation_image')->nullable();
            // relationshipt to users table
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vilations');
    }
};
