<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('project_category_id')->nullable()->after('category')->constrained()->nullOnDelete();
        });

        $names = [
            'power-projects' => 'Power Projects',
            'dams-hydropower' => 'Dams and Hydropower',
            'canals-barrages-drains' => 'Canals, Barrages and Drains',
            'environment' => 'Environment',
            'construction-highways' => 'Construction',
        ];

        $slugs = DB::table('projects')->whereNotNull('category')->distinct()->pluck('category');

        foreach ($slugs as $order => $slug) {
            $id = DB::table('project_categories')->insertGetId([
                'name' => $names[$slug] ?? str($slug)->replace('-', ' ')->title(),
                'slug' => $slug,
                'sort_order' => array_search($slug, array_keys($names), true) !== false
                    ? array_search($slug, array_keys($names), true)
                    : count($names) + $order,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('projects')->where('category', $slug)->update(['project_category_id' => $id]);
        }

        foreach ($names as $slug => $name) {
            DB::table('project_categories')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $name, 'sort_order' => array_search($slug, array_keys($names), true), 'is_active' => true, 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }

    public function down(): void
    {
        Schema::table('projects', fn (Blueprint $table) => $table->dropConstrainedForeignId('project_category_id'));
        Schema::dropIfExists('project_categories');
    }
};
