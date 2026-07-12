<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('status')->default('new')->after('message')->index();
            $table->string('source_ip', 45)->nullable()->after('status');
            $table->text('user_agent')->nullable()->after('source_ip');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', fn (Blueprint $table) => $table->dropColumn(['status', 'source_ip', 'user_agent']));
    }
};
