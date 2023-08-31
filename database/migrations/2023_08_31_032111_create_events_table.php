<?php

use App\Models\Organizer;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('event_image_path')->nullable();
            $table->foreignIdFor(Organizer::class)->constrained();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('city');
            $table->string('street');
            $table->string('building');
            $table->string('zip_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
