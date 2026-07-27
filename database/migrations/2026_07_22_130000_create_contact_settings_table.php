<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('notification_email')->nullable();
            $table->timestamps();
        });

        DB::table('contact_settings')->insert([
            'notification_email' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void { Schema::dropIfExists('contact_settings'); }
};
