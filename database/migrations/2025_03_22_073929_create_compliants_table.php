<?php

use App\Enums\CompliantStatus;
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
        Schema::create('compliants', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('message');
            $table->enum('status', getEnumsValue(CompliantStatus::cases()))->default(CompliantStatus::PENDING->value);
            // relationship to user
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliants');
    }
};
