<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('token', 40)->unique();
            $table->unsignedTinyInteger('passes_allocated')->default(1);
            $table->unsignedTinyInteger('passes_confirmed')->default(0);
            $table->enum('rsvp_status', ['pending', 'confirmed', 'declined'])->default('pending');
            $table->text('dietary_notes')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
