<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_settings', function (Blueprint $table): void {
            $table->string('email_heading')->default('Email Us')->after('notification_email');
            $table->string('office_heading')->default('Head Office')->after('email_heading');
            $table->string('company_name')->default('BARQAAB Consulting Services')->after('office_heading');
            $table->text('address')->nullable()->after('company_name');
            $table->string('phone')->nullable()->after('address');
            $table->string('fax')->nullable()->after('phone');
            $table->string('public_email')->nullable()->after('fax');
            $table->string('logo')->nullable()->after('public_email');
            $table->text('map_embed_url')->nullable()->after('logo');
        });

        DB::table('contact_settings')->update([
            'address' => "Sunny View Estate, Kashmir Road,\nLahore – Pakistan.",
            'phone' => '+92-042-99202093-94, 99203384',
            'fax' => '+92-042-99202095',
            'public_email' => 'info@barqaab.com',
            'map_embed_url' => 'https://www.google.com/maps?q=BARQAAB%20Consulting%20Services%20Sunny%20View%20Estate%20Kashmir%20Road%20Lahore&output=embed',
        ]);
    }

    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'email_heading', 'office_heading', 'company_name', 'address',
                'phone', 'fax', 'public_email', 'logo', 'map_embed_url',
            ]);
        });
    }
};
