<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_profile_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('number')->nullable();
            $table->text('details')->nullable();
            $table->string('document')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('about_profiles')->orderBy('id')->each(function ($profile): void {
            $registrations = json_decode($profile->registrations ?? '[]', true);

            foreach (is_array($registrations) ? $registrations : [] as $index => $registration) {
                if (blank($registration['title'] ?? null)) continue;

                DB::table('registrations')->insert([
                    'about_profile_id' => $profile->id,
                    'title' => $registration['title'],
                    'number' => $registration['number'] ?? null,
                    'details' => $registration['details'] ?? null,
                    'document' => $registration['document'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public function down(): void { Schema::dropIfExists('registrations'); }
};
