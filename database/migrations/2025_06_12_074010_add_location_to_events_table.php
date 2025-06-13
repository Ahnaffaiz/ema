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
        Schema::table('events', function (Blueprint $table) {
            $table->enum('location_type', ['physical', 'virtual'])->nullable()->after('short_link');
            $table->text('location_address')->nullable()->after('location_type')->comment('Physical address or venue name');
            $table->string('location_url')->nullable()->after('location_address')->comment('Meeting link (Zoom, Google Meet, etc.) or Google Maps link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'location_type',
                'location_address',
                'location_url',
                'location_latitude',
                'location_longitude'
            ]);
        });
    }
};
