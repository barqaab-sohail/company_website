<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('attributes_data')->nullable()->after('scope_of_services');
        });

        $project = DB::table('projects')
            ->where('slug', 'feasibility-study-for-raising-of-mangla-dam')
            ->first();

        if (! $project) {
            return;
        }

        $facts = [
            ['label' => 'Total Project Cost', 'value' => 'PKR 62,500 Million'],
            ['label' => 'BARQAAB Share', 'value' => '33%'],
            ['label' => 'Date of Commencement', 'value' => 'August 2000'],
            ['label' => 'Date of Completion', 'value' => 'December 2000'],
        ];

        $body = preg_replace(
            '/<p\b[^>]*>\s*Total Project Cost:.*?Date of Completion:.*?<\/p>/is',
            '',
            $project->body ?? ''
        );

        DB::table('projects')->where('id', $project->id)->update([
            'attributes_data' => json_encode($facts),
            'body' => $body,
        ]);
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('attributes_data');
        });
    }
};
