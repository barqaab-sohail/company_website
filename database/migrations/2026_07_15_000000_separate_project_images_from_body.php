<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('projects')->orderBy('id')->each(function ($project): void {
            $body = $project->body ?? '';

            if (! preg_match_all('/<img\b[^>]*\bsrc=["\']([^"\']+)["\'][^>]*>/i', $body, $matches, PREG_SET_ORDER)) {
                return;
            }

            $nextOrder = (int) DB::table('project_images')
                ->where('project_id', $project->id)
                ->max('sort_order') + 1;

            foreach ($matches as $match) {
                $tag = $match[0];
                $path = html_entity_decode($match[1]);
                preg_match('/\balt=["\']([^"\']*)["\']/i', $tag, $altMatch);

                if (! DB::table('project_images')->where('project_id', $project->id)->where('path', $path)->exists()) {
                    DB::table('project_images')->insert([
                        'project_id' => $project->id,
                        'path' => $path,
                        'alt_text' => html_entity_decode($altMatch[1] ?? $project->title),
                        'sort_order' => $nextOrder++,
                        'is_featured' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $body = preg_replace('/<figure\b[^>]*>\s*<img\b[^>]*>.*?<\/figure>/is', '', $body);
            $body = preg_replace('/<p\b[^>]*>\s*<img\b[^>]*>\s*<\/p>/is', '', $body);
            $body = preg_replace('/<img\b[^>]*>/i', '', $body);
            $body = preg_replace('/<p\b[^>]*>\s*(?:&nbsp;|<br\s*\/?\s*>)*\s*<\/p>/i', '', $body);

            DB::table('projects')->where('id', $project->id)->update([
                'body' => trim($body),
                'updated_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        // Images remain in the gallery; restoring imported body markup would duplicate them.
    }
};
