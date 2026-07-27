<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_profile_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('about_profiles')->orderBy('id')->each(function ($profile): void {
            $clients = json_decode($profile->clients ?? '[]', true);

            foreach (is_array($clients) ? $clients : [] as $index => $client) {
                if (blank($client['name'] ?? null)) {
                    continue;
                }

                DB::table('clients')->insert([
                    'about_profile_id' => $profile->id,
                    'name' => $client['name'],
                    'logo' => $client['logo'] ?? null,
                    'website' => $client['website'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
