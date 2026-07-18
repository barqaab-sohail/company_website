<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_openings', function (Blueprint $table) {
            $table->text('minimum_qualification')->nullable()->after('slug');
            $table->text('experience_required')->nullable()->after('minimum_qualification');
        });

        DB::table('job_openings')->orderBy('id')->each(function ($job): void {
            DB::table('job_openings')->where('id', $job->id)->update([
                'minimum_qualification' => $job->summary,
                'experience_required' => $job->description
                    ? trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode($job->description))))
                    : null,
            ]);
        });

        Schema::table('job_openings', function (Blueprint $table) {
            $table->dropColumn(['summary', 'description']);
        });
    }

    public function down(): void
    {
        Schema::table('job_openings', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('slug');
            $table->longText('description')->nullable()->after('summary');
        });

        DB::table('job_openings')->orderBy('id')->each(function ($job): void {
            DB::table('job_openings')->where('id', $job->id)->update([
                'summary' => $job->minimum_qualification,
                'description' => $job->experience_required,
            ]);
        });

        Schema::table('job_openings', function (Blueprint $table) {
            $table->dropColumn(['minimum_qualification', 'experience_required']);
        });
    }
};
