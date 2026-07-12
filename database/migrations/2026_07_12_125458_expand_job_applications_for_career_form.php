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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->foreignId('job_opening_id')->nullable()->after('content_id')->constrained()->nullOnDelete();
            $table->string('application_type')->default('general')->after('job_opening_id');
            $table->string('first_name')->nullable()->after('application_type');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('address')->nullable()->after('last_name');
            $table->string('city')->nullable()->after('address');
            $table->string('contact_type')->nullable()->after('phone');
            $table->json('education')->nullable()->after('contact_type');
            $table->decimal('total_experience', 5, 1)->nullable()->after('education');
            $table->string('source_ip', 45)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign(['job_opening_id']);
            $table->dropColumn(['job_opening_id','application_type','first_name','last_name','address','city','contact_type','education','total_experience','source_ip']);
        });
    }
};
