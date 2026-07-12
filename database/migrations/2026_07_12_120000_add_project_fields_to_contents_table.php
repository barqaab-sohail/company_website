<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('category')->nullable()->after('type')->index();
            $table->text('scope_of_project')->nullable()->after('body');
            $table->text('scope_of_services')->nullable()->after('scope_of_project');
        });
    }

    public function down(): void
    {
        Schema::table('contents', fn (Blueprint $table) => $table->dropColumn(['category', 'scope_of_project', 'scope_of_services']));
    }
};
