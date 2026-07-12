<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PDO;

class ImportWordPress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wordpress:import {--database=barqaab_wordpress} {--prefix=wp_bbey_}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import BARQAAB WordPress content and uploads into Laravel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname='.$this->option('database').';charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $p = preg_replace('/[^a-zA-Z0-9_]/', '', $this->option('prefix'));
        $sql = "SELECT p.*, thumb.guid featured_image, categories.category FROM {$p}posts p LEFT JOIN {$p}postmeta pm ON pm.post_id=p.ID AND pm.meta_key='_thumbnail_id' LEFT JOIN {$p}posts thumb ON thumb.ID=pm.meta_value LEFT JOIN (SELECT tr.object_id, MIN(t.slug) category FROM {$p}term_relationships tr JOIN {$p}term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id JOIN {$p}terms t ON t.term_id=tt.term_id WHERE tt.taxonomy LIKE '%portfolio%' GROUP BY tr.object_id) categories ON categories.object_id=p.ID WHERE p.post_status IN ('publish','private') AND p.post_type IN ('page','post','portfolios') ORDER BY p.menu_order,p.post_date";
        $count = 0;
        foreach ($pdo->query($sql) as $post) {
            $type = $post['post_type'] === 'portfolios' ? 'project' : $post['post_type'];
            $slug = $post['post_name'] ?: Str::slug($post['post_title']);
            Content::updateOrCreate(['wordpress_id' => $post['ID']], [
                'type' => $type, 'category' => $post['category'] ?: null, 'title' => html_entity_decode($post['post_title']),
                'slug' => $slug.'-'.($post['ID']), 'excerpt' => $post['post_excerpt'],
                'body' => $this->clean($post['post_content']),
                'featured_image' => $this->localMedia($post['featured_image']),
                'status' => $post['post_status'] === 'publish' ? 'published' : 'draft',
                'sort_order' => $post['menu_order'], 'published_at' => $post['post_date'],
                'meta' => ['original_slug' => $slug, 'original_url' => $post['guid']],
            ]); $count++;
        }
        foreach (['blogname'=>'site_name','blogdescription'=>'tagline','admin_email'=>'email'] as $old => $new) {
            $stmt = $pdo->prepare("SELECT option_value FROM {$p}options WHERE option_name=? LIMIT 1");
            $stmt->execute([$old]);
            Setting::updateOrCreate(['key'=>$new], ['label'=>Str::headline($new),'value'=>$stmt->fetchColumn() ?: '','group'=>'general']);
        }
        $source = base_path('source/extracted/barqaabcompk/wp-content/uploads');
        if (File::isDirectory($source)) { File::ensureDirectoryExists(public_path('uploads')); File::copyDirectory($source, public_path('uploads')); }
        $this->info("Imported {$count} published pages and projects, plus WordPress uploads.");
        return self::SUCCESS;
    }

    private function clean(?string $html): string
    {
        $html = preg_replace('/\[(?:\/?)[a-zA-Z_][^\]]*\]/', '', $html ?? '');
        return str_replace(['http://www.barqaab.com.pk/wp-content/uploads','https://www.barqaab.com.pk/wp-content/uploads'], '/uploads', $html);
    }

    private function localMedia(?string $url): ?string
    {
        if (! $url) return null;
        return '/uploads/'.ltrim((string) preg_replace('#^.*?/wp-content/uploads/#', '', $url), '/');
    }
}
